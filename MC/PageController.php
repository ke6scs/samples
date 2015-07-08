<?php
class PageController extends BaseController {

	public $restful = true;
    private $auth_lvl = '';

    /*
     *
     * Shows page from database keyed on a slug value from the URL
     *
     *
     */

	public function getIndex($slug = '',$link_id = 0)
	{
        $debug = '';
        $bmStart = microtime(true);
        $perpage = intval(AppConfig::get('articles_per_page',50));
        $branch_prefixes = explode(',',AppConfig::get('branch_prefixes'));
        $virtualPerpage = intval(AppConfig::get('virtual_per_page',20));
        $page = Page::where('slug', '=', $slug)->cacheTags('pages')->remember(1440)->first();
		//$page = Page::where('slug', '=', Str::slug($slug))->first();

		if (count($page) > 0)
		//if (is_null($page))
		{
            if ($filter_return = $this->authFilter($page->level)) {
                return $filter_return;
            }

            if ($page->redirect) {
                if (substr($page->redirect,0,1) == '{') {
                    $redir_arr = json_decode($page->redirect, true);
                    foreach ($redir_arr as $rlvl => $rslug) {
                        if (strpos($this->auth_lvl,$rlvl) !== false) {
                            return Redirect::to($rslug);
                        }
                    }
                    if (isset($redir_arr['def'])) {
                        return Redirect::to($redir_arr['def']);
                    }
                } else {
                    return Redirect::to($page->redirect);
                }
            }

            // get parameters from URL
            $page->category = Input::has('category') ? Input::get('category') : ($page->default_category ? $page->default_category : false);
            $page->section = Input::has('section') ? Input::get('section') : false;
            $page->keywordInput = $page->ddkeycol ? Input::get('keyword') : '';

            $page_vars = new stdClass;

            // separate slug into branch and section, if applicable
            $branch = $slug;
            if ($page->link_slug) {
                $branch = $page->link_slug;
            }
            $els = explode('/',$branch);
            if (in_array($els[0],$branch_prefixes) && count($els) > 1) {
                $branch = $els[0];
                if (!$page->section) {
                    $page->section = $els[1];
                }
            }

            $dta = normal::getTypes();

            // get list of categories, if there is a "ddlist"
            $categories = false;
            $normalized = false;
            if ($page->ddlist) {
                $fld = $page->ddlist;
                $catq = Link::where('branch', '=', $branch);
                if ($page->section) {
                    $catq->where('section', '=', $page->section);
                }
                if($dtp = array_search($fld,$dta)) {
                    $catq->join('data','data.rec_id','=','links.id')->where('data.table_name','=','links')->where('data.type','=',$dtp)->whereNull('data.deleted_at');
                    $fld = 'data_body';
                    $normalized = true;
                }
                $category_model = $catq->groupBy($fld)
                    ->whereRaw('trim(`'.$fld.'`) != ""')
                    ->cacheTags('links')->remember(1440)
                    ->get(array($fld));
                $categories = array('' => 'All');
                foreach ($category_model as $category_item) {
                    $categories[$category_item->{$fld}] = $category_item->{$fld};
                }
            }

            $links = false;
            $columns = false;

            // get list of links, specified by branch, section, category, state, and/or keyword
            if ($page->linkdef || ($link_id && $page->detaildef)) {

                // get column layout
                $columns = Listcolumns::where('def', '=', ($link_id ? $page->detaildef : $page->linkdef))
                    ->cacheTags('links')->remember(1440)
                    ->orderBy('listorder')->get();


                $perlinkpage = intval(AppConfig::get('links_per_page',50));
                $query = new Link;

                if ($link_id) {
                    $query = $query->where('id', '=', $link_id);
                } else {
                    if ($page->section) {
                        $query = $query->where('section', '=', $page->section);
                    }
                    if ($page->category) {
                        if ($normalized) {
                            $query = $query->join('data AS d','d.rec_id','=','links.id')->where('d.table_name','=','links')->where('d.type','=',$dtp)->whereNull('d.deleted_at');
                        }
                        $query = $query->where(isset($fld)?$fld:($page->section ? 'category' : 'section'), '=', $page->category);
                    }
                    if ($page->state) {
                        $query = $query->where('state', '=', $page->state);
                    }
                    if ($page->keywordInput) {
                        if ($page->keywordInput == "by_date") {
                            $query = $query->join('data AS d','d.rec_id','=','links.id')->where('d.table_name','=','links')->where('d.type','=',7)->whereNull('d.deleted_at');
                            $month = Input::get('themonth');
                            $year = Input::get('theyear');
                            $pfx = $year.'-'.$month;
                            $start_date = $pfx.'-01';
                            $end_date = $pfx.'-'.cal_days_in_month(CAL_GREGORIAN,$month,$year);
                            $query = $query->whereRaw('d.`data_body`  BETWEEN ? AND ?',array($start_date,$end_date));
                            unset($page->keywordInput);
                            $page_vars->month = $month;
                            $page_vars->year = $year;
                        } else {
                            $query = $query->whereRaw('`' . $page->ddkeycol . '` RLIKE ?', array($page->keywordInput));
                        }
                    }
                    if (!$page->allowBroken) {
                        $query = $query->join('link_check','links.id','=','link_check.id');
                        $query = $query->whereBetween('link_check.last_result',array('200','399'));
                    }

                }
                $order = 'name';
                $orderdir = 'asc';
                if ($page->linkorder) {
                    $ordera = explode(',',$page->linkorder);
                    $order = $ordera[0];
                    if (count($ordera) > 1) {
                        $orderdir = $ordera[1];
                    }
                    if($dtp = array_search($order,$dta)) {
                        $query = $query->join('data AS d2','d2.rec_id','=','links.id')->where('d2.table_name','=','links')->where('d2.type','=',$dtp)->whereNull('d2.deleted_at');
                        $order = 'd2.data_body';
                    }
                }
                if ($page->where) {
                    $query = $query->whereRaw($page->where);
                }
                if ($page->remove_dupes) {
                    $query = $query->groupBy('name','url');
                }
                $links = $query->where('branch', '=', $branch)
                    ->select(array('links.*'))
                    ->orderBy($order,$orderdir)
                    ->cacheTags('links')->remember(1440)
                    ->paginate($perlinkpage);

                $ids = array();
                foreach ($links as $link) {
                    $ids[] = $link->id;
                }

                $xda = count($ids) ? Cache::tags('links')->remember('linkData|'.implode('-',$ids), 1440, function () use($ids) {
                    $xdata = Data::where('table_name', '=', 'links')
                        ->join('data_types','data_types.id','=','data.type')
                        ->whereIn('rec_id', $ids)
                        ->whereNull('data_types.deleted_at')
                        ->cacheTags('data')->remember(10080)
                        ->get();
                    $xdda = array();
                    foreach ($xdata as $xrec) {
                        $xdda[$xrec->rec_id][$xrec->label] = $xrec->data_body;
                    }
                    return $xdda;
                }) : array();

                foreach ($links as $lid => $link) {
                    $id = $link->id;
                    if (isset($xda[$id])) {
                        foreach ($xda[$id] as $xid => $xdt) {
                            $links[$lid]->{$xid} = $xdt;
                        }
                    }
                }
            }

            $thumbs = false;
            if ($page->virtual_type) {

                $thumbs = Ad::where('type', '=', $page->virtual_type)
                    ->where('category', '=', $page->category)
                    ->orderBy('vorder','desc')
                    ->cacheTags('ads')->remember(1440)
                    ->paginate($virtualPerpage);

                foreach ($thumbs as $thumb) {
                    Ads::track($thumb, 3, $page->id);
                }

                // get list of categories
                $category_model = Ad::groupBy('category')
                    ->where('type', '=', $page->virtual_type)
                    ->cacheTags('ads')->remember(1440)
                    ->get(array('category'));

                $categories = array();
                foreach ($category_model as $category_item) {
                    $categories[$category_item->category] = $category_item->category;
                }
//                $page->dname = 'Category';
            }

            // benchmarking the database access
            $bmEnd = microtime(true);
            $page->elapsed = $bmEnd - $bmStart;

            $page_vars->qstring = '';
            if ($page->pass_query == 'Y') {
                $qry = Input::query();
                $qry['mc_rnm'] = substr(time(),2);
                if (count($qry)) {
                    $page_vars->qstring = '?'.http_build_query($qry);
                }
            }

            if ($page->randomize) {
                foreach(explode(',',$page->randomize) as $random_tag) {
                    $page_vars->{$random_tag} = mt_rand(10000,99999);
                }
            }

            foreach (AppConfig::getAll() as $cfi => $cfd) {
                $page_vars->{$cfi} = $cfd;
            }
            $page_vars->nocache = NOCACHE_CODE;
            if (!$page->layout) {
//                if ($_SERVER['REMOTE_ADDR'] == '108.47.107.194') {
//                    $page->layout = 'template.layout2';
//                } else {
                    $page->layout = 'template.layout';
//                }
            }

            // get data on child and parent pages
            $childpages = new Page;
            $P = clone($childpages->getConnection()->getPaginator());
            $P->setPageName('article');
            $childpages->getConnection()->setPaginator($P);
            $childpages = $childpages->join('article_pages','pages.id','=','article_pages.page_id');
            $childpages = $childpages->where('article_pages.parent_id', '=', $page->id);
            $childpages = $childpages->whereNull('article_pages.deleted_at');
            $childpages = $childpages->orderBy('pageOrder');
            $childpages = $childpages->cacheTags('pages')->remember(1440);
            $childpages = $childpages->paginate($perpage);

            // pass ALL the data to the view
            return View::make('page.page')
                ->with('dyn_layout', $page->layout)
                ->with('page',       $page)
                ->with('childpages', $childpages)
                ->with('categories', $categories)
                ->with('links',      $links)
                ->with('link_id',    $link_id)
                ->with('thumbs',     $thumbs)
                ->with('columns',    $columns)
                ->with('top_banner', empty($slug))
                ->with('debug',      $debug)
                ->with('parse_body', Display::format($page->body, $page_vars, false, false));
		} else {
            if (substr($slug,-5) == '.html') {
                $new_slug = substr($slug,0,-5);
                $new_page = Page::where('slug', '=', $new_slug)->cacheTags('pages')->remember(1440)->first();
                if (count($new_page) > 0) {
                    return Redirect::to('/'.$new_slug, 301);
                }
            }
            $missing = new Missing;
            $missing->slug = $slug;
            $missing->referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "[none]";
            $missing->save();
            AppLog::alert('Page Not Found',404,json_encode(array('slug'=>$slug)));

            return Response::view('page.notfound', array('slug'=>$slug), 404);
		}

	}

    private function authFilter($level)
    {
        $auth = Auth::check();
        $this->auth_lvl = $auth ? Auth::user()->access : '';
        if (!$level) {
            return false;
        }
        if ($auth) {
            if ($level = 'prem') { return false; }
//error_log('page access? '.Auth::user()->access);
            if (count(array_intersect(explode(',',$this->auth_lvl), explode(',',$level))) == 0) {
                Session::put('attemptLevel',$level);
                Session::put('url.intended',Request::url());
                return Redirect::guest('/login?m=na&lvl='.htmlentities($level).'&w='.$this->auth_lvl);
            } else {
                return false;
            }
        } else {
            Session::put('attemptLevel',$level);
            Session::put('url.intended',Request::url());
            return Redirect::guest('/login?m=ns&lvl='.$level);
        }
    }

    public function getRss($slug = '')
    {
        Config::set('laravel-debugbar::config.enabled', false);
        $rss = new Rss;
        return $rss->getPage($slug);
    }

    public function getContactForm()
    {
        return View::make('page.contact')->with('captcha_random',$this->getCaptchaRandom());
    }

    public function postContactForm()
    {
        $fields = array(
            'contact' => 'Contact Name',
            'email' => 'E-Mail',
            'Company' => false,
            'phone' => false,
            'TypeOfInquiry' => false,
            'url' => false,
            'Comment' => 'Comment',
            'ImageField' => 'Security Code',
        );
        $xtra = array(
            'email' => 'email',
        );
        $input = array();
        $validate = array();
        $rules = array();
        $errors = '';
        $valid = true;
        foreach ($fields as $field => $required) {
            $fdat = Input::get($field);
            $input[$field] = $fdat;
            if ($required){
                $validate[$required] = $fdat;
                $rules[$required] = 'required'.(isset($xtra[$field]) ? '|'.$xtra[$field] : '');
            }
        }
        $validator = Validator::make(
            $validate,
            $rules
        );
        if ($validator->fails()) {
            $valid = false;
            $messages = $validator->messages();
            foreach ($messages->all() as $emessage)
            {
                $errors .= '<br />'.$emessage;
            }
        }
        if ($input['ImageField'] && $input['ImageField'] != Session::get('captcha_val')) {
            $valid = false;
            $errors .= '<br />The Security Code is invalid.';
        }

        if ($valid) {
            $input['stamp'] = date('j/n/Y g:i:s A');
            $mail_data = array();
            $mail_template = MailTemplate::where('name', '=', 'contact_form')->first();
            $mail_data['body'] = Display::format($mail_template->content, $input);

            Mail::queue(array('text' => 'emails.generic'), $mail_data, function($message) use ($input, $mail_template)
            {
                $message->from($input['email'],$input['contact']);
                $message->to('info@militaryconnection.com')->subject($mail_template->subject);
            });

            return Redirect::to('/contactRcvd');
        } else {
            return View::make('page.contact')
                ->with('dat',$input)
                ->with('captcha_random',$this->getCaptchaRandom())
                ->with('error_text',$errors);
        }
    }

    private function getCaptchaRandom()
    {
        return mt_rand(10000,99999);
    }
}
