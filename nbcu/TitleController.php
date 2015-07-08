<?php

class TitleController extends BaseController 
{

    public $categories = array(); 
 	
	public function __construct()
    {
        $this->beforeFilter('permissions');
        //$this->beforeFilter('auth.basic');

         $this->categories = array(
               10 => "TV Series",
               11 => "Feature Films",
               12 => "Original Home Video",
               15 => "TV Movies",
               17 => "Mini Series",
               18 => "Specials"
        );
        
    }
	
	
	
	public function postDelete()
	{
	     $title_id = Input::get('title_id'); 
	     //$title = Title::find($title_id)->pluck("name");
	     $affectedRows = Title::where('id', '=', $title_id)->delete();
         
         $message_result = $affectedRows ? "Title deleted" : "An unexpected error occurred while deleting title";
                
         return Redirect::to('title/list')->withMessage($message_result);
	}
	
	
	
	private function getUserLastCollectionUsed() 
	{
	     $user_id = Auth::user()->id;
	     $coll_id = Collection::where('user_id', $user_id)->where("last_used", 1)->pluck('id');
	    // dd($coll_id);
	     if ($coll_id)
	       return $coll_id;
	     else
	       return null;
	}
	
	public function getList($param=null, $genre_param=null )
    {


         // We may want to separate the ajax calls in another route, but for now, I just used this feature of Laravel, Request::ajax(),
         // that detects if the call to this route was via Ajax, and included it with the regular call for the initial page load
         // of title listing
	    
	    $user_id = Auth::user()->id;
	    $user = User::find($user_id);
	    $usertype = $user->usertype_id;

        $myFaves = Favorite::where("user_id","=",$user_id)->get();
        $fave_array = array();

        foreach ($myFaves as $fave_rec) {
            $fave_array[] = $fave_rec->title_id;
        }


        if (Request::ajax()) {   // 3 ways to get here:  1.) The "Get More" button in list.blade.php, 2.) ProductType/Category checkboxes on left side 3.) the Sorting Dropdown at upper right
		    
		    $totalcount = 0;
		    
		    
		    if ( Input::has('page') ) {
		         $page = Input::get('page');  // The url paramater in the $.get call  would include the page parameter    
		    } else {
		       $page = 1;
		    }
           
            if ( Input::has('sortby') )
            {
                $sortparam = Input::get('sortby');
            } else {
                $sortparam = "a-z";
            }
            
            if ( $sortparam == "a-z" )
            {
                $sortstring_a = 'titles.name';
                $sortstring_b = 'asc';
            }
            else if ( $sortparam == "z-a" )
            {
                $sortstring_a = 'titles.name';
                $sortstring_b = 'desc';
            }
            else // recently-edited
            {
                $sortstring_a = 'titles.created_at';
                $sortstring_b = 'desc';
            }
            
            $tempresult = Title::with(array( "genre", "thumbnail"));          // "producttype"));
            
           // prod id's not relevant until they give us the final decision on taxonomy implementation
           // --------------------------------------------------------------------------- 
           /* if ( Input::has('prodids') ) 
            {
                $prodid_array =  Input::get('prodids');
                
                $tempresult = $tempresult->whereHas('producttype', function($producttype) use ($prodid_array)
                {
                    $producttype->whereIn('id',  $prodid_array);
    
                });

            }*/
            
            if ( $param == "favorites" ) 
            {
                $tempresult = $tempresult->with(array("favorite"))->whereHas('favorite', function($favorite)  use ($user_id)
                {
                    $favorite->where('user_id', "=", $user_id);
                });
	         }
            
            if ( Input::has('genres') )
            {
                $genre_array =  Input::get('genres');
                $tempresult = $tempresult->with(array("genre"))->whereHas('genre', function($genre) use ($genre_array)
                {
                    $genre->whereIn('genre_id',  $genre_array);
                    //->with('genretitle');
                });
            }
            

            if ( Input::has('categories') )
            {
                $category_array =  Input::get('categories');
                $tempresult = $tempresult->whereIn('producttype_id', $category_array);
                
            }
           
            if ( $usertype == 2 || $usertype == 5 || $usertype == 3 )  // Don't list unpublished titles in Client Title Listing
            {
                $tempresult = $tempresult->where("status_id","=", '3');
            } 
            else if ( Input::has('published_status') ) 
            {
                $tempresult = $tempresult->where("status_id","=", Input::get('published_status'));
            }
             
             $titles =  $tempresult->orderBy($sortstring_a, $sortstring_b)->paginate(24);
             
             foreach ( $titles as $key => $title ) 
             {
                // error_log($title); 
                if ( in_array($title['id'],$fave_array) )
                   $titles[$key]['faved'] = 1;
                else
                   $titles[$key]['faved'] = 0;
                
                if (count($title['thumbnail']) > 0) {
                    $titles[$key]['thumbpath'] = asset( Config::get('nbc.imageRootImagePath') . '/' . $title['thumbnail'][0]['file']);
                } else {
                    $titles[$key]['thumbpath'] = asset( 'images/publicThumb.jpg');
                    //unset($titles[$key])
                }

             }
             
             $totalcount = $tempresult->count();
             
             $success = (is_null($titles)) ? false : true;
             $success = true;

             if ( $success ) 
             {
                if ($param) 
                    $param_send = $param;
                else
                    $param_send = "normal";
                $data = json_encode(array(
                      'titles' =>  View::make('titles.title_grid_template', array('titles' => $titles, 'mode' => $param))->render(),
                      'totalCount' => $totalcount,
                      'mode' => $param_send,
                      'currentPageCount' => $titles->count()
                 ));

                 return $data;
              }
               // return Response::json(View::make('titles.title_grid_template', array('titles' => $titles, 'mode' => $param))->render());  
             else
                return $this->makeSuccessArray($success);

              
		} else {  // Normal call to the route for a title listing here 
		    
		    $genre_label  = "";
		    $category_label  = "";
		    // Prep the left sidebar filtering widget data
		    $genres = Genre::orderBy("name","asc")->where('show','=',1)->get()->toArray();
		    
		    // Prep the left sidebar filtering widget data
		    $sidebar_categories = $this->getCategoriesForSidebar();
		    
		   
            // If this input exists, it means User clicked "Add More Titles" button
            // From the "View Collections" page
            if ( Input::has('default_collection_id') )
            {
                $default_collection_id = Input::get('default_collection_id');
            } 
            else  
            {
                $default_collection_id = $this->getUserLastCollectionUsed();
            }
            $user_id = Auth::user()->id;
            //$collections = Collection::where("user_id","=",$user_id)->get(array('id', 'name'))->toArray(); 
            $collections = Collection::select('id', 'name')->where("user_id","=",$user_id)->where("status_id","<>",6)->orderBy('name')->get()->toArray();
            
            $collection_dropdown = array();
            foreach ( $collections as $collection )
            {
                $shortened_coll_name = str_limit($collection['name'], 25);
                $collection_dropdown[$collection['id']] = $shortened_coll_name;
            
            }
            if (isset($default_collection_id) && ($default_collection_id))
            {
                $first_collection_id = $default_collection_id;
            }
            else
            {
                reset($collection_dropdown);
                $first_collection_id = key($collection_dropdown);
            }
            
           
            //$tempresult = Title::with(array("genre","thumbnail", "producttype"))->orderBy('created_at', 'desc');
            $tempresult = Title::with(array("genre","thumbnail", "producttype"))->orderBy('name', 'asc');

            if ($param)
                $param_send = $param;
            else
                $param_send = "normal";

            if ( $param == "favorites" )
             {
                
                    $tempresult = $tempresult->with(array("favorite"))->where("status_id","=", 3)->whereHas('favorite', function($favorite)  use ($user_id)
                    {
                        $favorite->where('user_id', "=", $user_id);
        
                    });
	               
	          }
	         if ( $param == "recommended" ) 
             {
                    $tempresult = $tempresult->with(array("recommendation"))->where("status_id","=", 3)->whereHas('recommendation', function($recommendation)  use ($user_id)
                    {
                        $recommendation->where('user_id', "=", $user_id);
        
                    });
	          } 
	          
	         if ( $param == "genre" )
             {
                 if ( !$genre_param ){
                     Redirect::to("/");
                 }
                 $genre_label = Genre::where("id","=",$genre_param)->pluck("name");
                 
                 $tempresult = $tempresult->with(array("genre"))->where("status_id","=", 3)->whereHas('genre', function($genre)  use ($genre_param)
                 {
                        $genre->where('genre_id', "=", $genre_param);
        
                 });
                 
             }
             
             if ( $param == "category" )
             {
                 if ( !$genre_param ){
                     Redirect::to("/");
                 }
                 
                 $category_label = $this->getCategoryLabel($genre_param);
                 
                 $tempresult = $tempresult->where("status_id","=", 3)->where('producttype_id', "=", $genre_param);
        
                 
                 
             }

             $rev_category = array(
                 "tvseries" => 10,
                 "featurefilms" => 11,
                 "orighomerelease" => 12,
                 "tvmovie" => 15,
                 "miniseries" => 17,
                 "specials" => 18,
             );
             
             if ( isset($rev_category[$param]) )
             {
                 $genre_param = $rev_category[$param];
                 $param_send = "category";
                 $tempresult = $tempresult->with(array("producttype"))->where("status_id","=", 3)->whereHas('producttype', function($producttype) use ($genre_param)
                 {
                        $producttype->where('id', "=", $genre_param);
        
                    });
                 $category_label = $this->categories[$genre_param];
             }

             if ( $usertype == 2 || $usertype == 5 || $usertype == 3 )  // Don't list unpublished titles in Client or Sales Title Listing
            {
             
                $tempresult = $tempresult->where("status_id","=", '3');
            }
            
            $titles =  $tempresult->with(array("thumbnail"))->take(24)->get()->toArray();

            //dd($titles);
            foreach ( $titles as $key => $title ) {

                if ( in_array($title['id'],$fave_array) )
                   $titles[$key]['faved'] = 1;
                else
                   $titles[$key]['faved'] = 0;
                
                if (count($title['thumbnail']) > 0) {
                    $titles[$key]['thumbpath'] = asset( Config::get('nbc.imageRootImagePath') . '/' . $title['thumbnail'][0]['file']);
                } else {
                    $titles[$key]['thumbpath'] = asset( 'images/publicThumb.jpg');
                }
                   
                   
            }
            
            $total_count = $tempresult->count();
            
            $data = array(
                'collections' =>  $collection_dropdown,
                'titles' => $titles,
                'checked_genre' => $genre_param,
                'checked_category' => $genre_param,
                'first_collection_id' => $first_collection_id,
                'initial_view_col_link' => '/collection/manage/' .  $first_collection_id,
                'logged_in_user_id' => $user_id,
                'mode' => $param_send,

            );
            
            return View::make('titles.list', compact("data","total_count","genres","genre_label", "category_label", "sidebar_categories"));
		    
		}
	
	}
	
	private function getCategoriesForSidebar()
	{
	
	    return $this->categories;
	}
	
	private function getCategoryLabel($category_param)
	{
	     
        return $this->categories[$category_param];
	    
	}
	
	/* This is called when user is searching with the site-wide top popup search widget on header */
	public function getSearch($term="")
	{
        if (Auth::user()->allow_search == 0) {
            App::abort(403, 'Insufficient permissions.');
        }
        $page_size = 24;
        $start = 0;

        if (Request::ajax()) {
            $search_term = Input::get('search_term');
        } else {
            $search_term = $term;
        }

        $actor_ids = Actor::where("name","LIKE","%".$search_term."%")->join('titles_actors','titles_actors.actor_id','=','actors.id')->lists('title_id');
        $director_ids = Director::where("name","like","%".$search_term."%")->join('titles_directors','titles_directors.director_id','=','directors.id')->lists('title_id');
        $producer_ids = Producer::where("name","LIKE","%".$search_term."%")->join('titles_producers','titles_producers.producer_id','=','producers.id')->lists('title_id');
        $writer_ids = Writer::where("name","LIKE","%".$search_term."%")->join('titles_writers','titles_writers.writer_id','=','writers.id')->lists('title_id');

        $ids = array_merge($actor_ids,$director_ids,$producer_ids,$writer_ids);

        if (empty($ids)) {
            $ids = array(0);
        }

        $myFaves = Favorite::where("user_id","=",Auth::user()->id)->get();
        $fave_array = array();

        foreach ($myFaves as $fave_rec) {
            $fave_array[] = $fave_rec->title_id;
        }

        if (Request::ajax()) {

            if (Input::has('page')) {
                $start = (intval(Input::get('page')) -1) * $page_size;
            }

            $return_more = Input::get('fetch') == "more";
            $columns = $return_more ? array("*") : array("id","name");

            $tmptitles = Title::select($columns)
                ->where('status_id','=', '3')
                ->where(function($query) use ($search_term,$ids)
            {
                $query->whereIn("id",$ids)
                    ->orWhere("name","like","%".$search_term."%")
                    ->orWhere("actors","like","%".$search_term."%")
                    ->orWhere("directors","like","%".$search_term."%")
                    ->orWhere("producers","like","%".$search_term."%")
                    ->orWhere("writers","like","%".$search_term."%");
            });

            if ($return_more) {
                $tmptitles = $tmptitles->with(array( "genre", "thumbnail"));
                $titles = array_slice($tmptitles->get()->toArray(),$start,$page_size);

                foreach ( $titles as $key => $title )
                {
                    // error_log($title);

                    if ( in_array($title['id'],$fave_array) )
                        $titles[$key]['faved'] = 1;
                    else
                        $titles[$key]['faved'] = 0;

                    if (count($title['thumbnail']) > 0) {
                        $titles[$key]['thumbpath'] = asset( Config::get('nbc.imageRootImagePath') . '/' . $title['thumbnail'][0]['file']);
                    } else {
                        $titles[$key]['thumbpath'] = asset( 'images/publicThumb.jpg');
                        //unset($titles[$key])
                    }

                }


                return  json_encode(array(
                    'titles' =>  View::make('titles.title_grid_template', array('titles' => $titles, 'mode' => "normal"))->render(),
                    'totalCount' => $tmptitles->count(),
                    'mode' => 'search_mode',
                    'currentPageCount' => count($titles),
                ));
            } else {
                $titles = $tmptitles->get()->toArray();

                foreach ( $titles as $key => $title )
                {
                    $titles[$key]['name'] = repair_a_the($title['name']);
                }

                return $this->makeSuccessArray( true, array("title_results" => $titles, "found" => (count($titles)?"1":"0") ));
            }
        } else {
            $search_term = $term;
            $genre_param = "";
            // placeholder stuff
            $genre_label  = "Results for: ";
            $genre_label .= "<span style='font-size:35px'>&ldquo;</span>";
            $genre_label .= $search_term;
            $genre_label .= "<span style='font-size:35px'>&rdquo;</span>";

            // Prep the left sidebar filtering widget data
            $genres = Genre::orderBy("name","asc")->get()->toArray();
            $sidebar_categories = $this->getCategoriesForSidebar();
            // If this input exists, it means User clicked "Add More Titles" button
            // From the "View Collections" page
            if ( Input::has('default_collection_id') )
            {
                $default_collection_id = Input::get('default_collection_id');
            }
            else
            {
                $default_collection_id = $this->getUserLastCollectionUsed();
            }
            $user_id = Auth::user()->id;
            //$collections = Collection::where("user_id","=",$user_id)->get(array('id', 'name'))->toArray();
            $collections = Collection::select('id', 'name')->where("user_id","=",$user_id)->where("status_id","<>",6)->orderBy('name')->get()->toArray();

            $collection_dropdown = array();
            foreach ( $collections as $collection )
            {
                $shortened_coll_name = str_limit($collection['name'], 25);
                $collection_dropdown[$collection['id']] = $shortened_coll_name;

            }
            if (isset($default_collection_id) && ($default_collection_id))
            {
                $first_collection_id = $default_collection_id;
            }
            else
            {
                reset($collection_dropdown);
                $first_collection_id = key($collection_dropdown);
            }
            // ------------------  Finally, the actual query to get matching titles ------------------
            $tempresults = Title::with(array("genre","thumbnail", "producttype"))
                ->where('status_id','=', '3')
                ->where(function($query) use ($search_term,$ids)
            {
                $query->whereIn("id",$ids)
                    ->orWhere("name","like","%".$search_term."%")
                    ->orWhere("actors","like","%".$search_term."%")
                    ->orWhere("directors","like","%".$search_term."%")
                    ->orWhere("producers","like","%".$search_term."%")
                    ->orWhere("writers","like","%".$search_term."%");
            });

            $results = array_slice($tempresults->get()->toArray(),$start,$page_size);

            foreach ( $results as $key => $title ) {

                if ( in_array($title['id'],$fave_array) )
                    $results[$key]['faved'] = 1;
                else
                    $results[$key]['faved'] = 0;

                if (count($title['thumbnail']) > 0) {
                    $results[$key]['thumbpath'] = asset( Config::get('nbc.imageRootImagePath') . '/' . $title['thumbnail'][0]['file']);
                } else {
                    $results[$key]['thumbpath'] = asset( 'images/publicThumb.jpg');
                }


            }


            $data = array(
                'collections' =>  $collection_dropdown,
                'titles' => $results,
                'checked_genre' => $genre_param,
                'first_collection_id' => $first_collection_id,
                'initial_view_col_link' => '/collection/manage/' .  $first_collection_id,
                'logged_in_user_id' => $user_id,
                'mode' => "search_mode"

            );


            $total_count = $tempresults->count();
            return View::make('titles.list', compact("data","total_count","genres","genre_label", "sidebar_categories"));


        }

    }
	
	private function getVideoType( $videopath ) 
	{
	    
	    $pos  = strripos($videopath, ".");
	    $extension = substr( $videopath , $pos + 1);
	    
	    switch  ( $extension ) {
	        case "mov":
	            $type = "mov";
	            break;
            case "mp4":
	            $type = "mp4";
	            break;
            case "ogv":
	            $type = "ogg";
	            break;
            default:
	          $type = "mp4";
	    }
      return $type;	    
	    
	}
	
	public function getPartialsynopsis() 
	{
	    $title_id = Input::get('title_id');
	    
	    $num_chars = Input::get('num_chars');
	    
	    $synopsis = Title::where('id', $title_id)->pluck('synopsis');
	    $synopsis = str_limit($synopsis, $num_chars);
	    //error_log($synopsis);
	   
	    return Response::json(['partial_synopsis' => $synopsis]);
	    
	    
	}
	
	public function getDetails($title_id)
    {
          if ( !$title_id  )
          {
               Redirect::to("/");
          }

        $title_db = Title::with(array("gallery_image", "video", "genre","rating","producttype"))->find($title_id);
        if (!is_object($title_db)) {
            return Redirect::to("/");
        }

        $title_db->favorite = Favorite::where("title_id","=",$title_id)->where("user_id","=",Auth::user()->id)->get();

        $title = $title_db->toArray();

        //dd($title);

          // Get all Image paths for this title
          // ---------------------
          if ( count($title['gallery_image']) > 0)  {
              $gallery_image_path = Config::get('nbc.imageRootImagePath') .  $title['gallery_image'][0]['file'];
          } else {
              $gallery_image_path = "/images/x-image-placeholder.png";
          }
          $fullpath_to_gallery_image = $gallery_image_path;
          
          // Get all Video paths for this title
          // ---------------------
          $video_file_path_array = array();
          
          if ( is_array( $title['video'] ) && count($title['video']) > 0) {
              foreach ( $title['video'] as $video ) {
                 $videofile_path = $this->getTitleVideoPath($title['final_title']);
                 $videofile_localpath = Config::get('nbc.imageRootLocalVideoPath');
                  if (!$videofile_localpath && strpos($videofile_path,'://') === false) {
                      $videofile_localpath = $videofile_path;
                  }

                  $fileExists = false;
                 // Get file headers to determine 404
                 if ($videofile_localpath && file_exists($_SERVER['DOCUMENT_ROOT'].$videofile_localpath . $video['file'])) {
                     $fileExists = true;
                     $videofile_path = $videofile_localpath;
                 }
                 if (!$fileExists && $videofile_localpath != $videofile_path && curl_htmlcode($videofile_path . $video['file']) != 404) {
                     $fileExists = true;
                 }

                 if ($fileExists) {
                     $video_file_path_array[] = array("filepath" => $videofile_path . $video['file'], "type" => $this->getVideoType($video['file']), "id" => $video['id'] );
                 }
              }
          }
          
          $cast_array = explode(",",$title['actors']);
          $directors_array = explode(",",$title['directors']);
          $producers_array = explode(",",$title['producers']);
          $writers_array = explode(",",$title['writers']);
          $awards_array = explode(",",$title['awards']);
          
          $genres = array();
          if ( is_array($title["genre"]) ) {
              foreach ( $title["genre"] as $genre ) {
                  $genres[] = $genre['name'];
              }
          }
          
          if ($title['rating']['name'] == "") {
             $rating = "none";
          } else {
             $rating = $title['rating']['name'];
          }
          
          if ( $title['color'] == "1") {
             $color = "color";
          } else {
             $color = "black & white";
          }
          
          
           
           
          /* if ( strlen( $title['synopsis'] ) > 720 ) {
                $partialsynopsis = str_limit($title['synopsis'],720);
                $enable_more = 1;
           } else {
              //synop = t ( synop );
              $enable_more = 0;
              $partialsynopsis = "";
           }*/

            $user_id = Auth::user()->id;

            $collections = Collection::select('id', 'name')->where("user_id","=",$user_id)->where('status_id','<>','6')->orderBy('name')->get()->toArray();
          
            $collection_dropdown = array();
            foreach ( $collections as $collection )
            {
                $shortened_coll_name = str_limit($collection['name'], 25);
                $collection_dropdown[$collection['id']] = $shortened_coll_name;
            
            }
          
            $default_collection_id = $this->getUserLastCollectionUsed();
            
            if (isset($default_collection_id) and ($default_collection_id))
            {
                $first_collection_id = $default_collection_id;
            }
            else
            {
                reset($collection_dropdown);
                $first_collection_id = key($collection_dropdown);
            }
          
           // Add insert to Report table, for reporting
           $user_id = Auth::user()->id;
           $user = User::find($user_id);
           $report = Report::create(
                      array(
                            'date' => time(),
                             'action_type' =>  1,
                             'action_user_id' =>  $user_id,
                              'object_id' =>  $title_id, 
                              'report_type' => 1,
                              'aux_object' =>  $user['region_id']
                           ));
          
           $report = Report::create(
                      array(
                            'date' => time(),
                             'action_type' =>  1,
                             'action_user_id' =>  $user_id,
                              'object_id' =>  $title_id, 
                              'report_type' => 3,
                              'aux_object' =>  $user['region_id']
                           ));

          // Unpack serialized runtimes
          if ($title['runtime_serialized'] != '')
          {
              $title['runtimes'] = unserialize($title['runtime_serialized']);
          }
          else
          {
              $title['runtimes'][0] = array('episode_cnt' => $title['episode_cnt'],'runtime_minutes_cnt' => $title['runtime_minutes_cnt']);
          }          

          $data = array("title" => $title,
                        "mode" => "preview_title",
                        "actors" => $cast_array,
                        "directors" => $directors_array,
                        "producers" => $producers_array,
                        "writers" => $writers_array,
                        "awards" => $awards_array,
                        "genres" => $genres,
                        "rating" => $rating,
                        "color" => $color,
                        'first_collection_id' => $first_collection_id,
                         'collections' =>  $collection_dropdown,
                        'gallery_image_path' => $fullpath_to_gallery_image,
                        'video_file_path_array' => $video_file_path_array
                        );
          
           //dd($enable_more);
          //dd($partialsynopsis);
          
          return View::make('titles.details')->with('data', $data);    
    
    } 
    
    public function getPrevieweditimage()
    {
         $filename = Input::get('filename');
         
         $destination_path =  Config::get('nbc.imageRootImagePath') . $filename;
         
         return Response::json(['fullpath' => $destination_path]);
    
    }
    
    public function getTitlemediaedit($title_id)
    {
          $title_db = Title::with(array("gallery_image", "billboard_image", "sellsheet_image", "thumbnail", "genre"))->find($title_id);
          if (!is_object($title_db)) {
              return Redirect::to("/");
          }
          $title = $title_db->toArray();
          // $data['title']['sellsheet_image']['0']['file']
          
          if ( !isset($title['sellsheet_image']['0']['file'] )) {
              $title['sellsheet_image']['0']['file'] = "Sellsheet image not set";
          }
          if ( !isset($title['billboard_image']['0']['file'] )) {
              $title['billboard_image']['0']['file'] = "Billboard image not set";
          }
          if ( !isset($title['gallery_image']['0']['file'] )) {
              $title['gallery_image']['0']['file'] = "Gallery image not set";
          }
    }
    public function getEdit($title_id)
    {
        if ( !$title_id  )
        {
            Redirect::to("/");
        }

        $title_db = Title::with(array("gallery_image", "billboard_image", "sellsheet_image", "thumbnail", "genre", "network"))->find($title_id);
        if (!is_object($title_db)) {
            return Redirect::to("/");
        }
        $title = $title_db->toArray();

           
          $genres = Genre::get(array('id', 'name'))->toArray(); 
          
          foreach ( $genres as $key => $genre ) {
              if ( $this->title_has_this_genre($genre['id'], $title) ) {
                   $genres[$key]['selected'] = 1;
              }
          }
          
          $network_options = Network::lists('name', 'id');
          
          $language_options = Language::lists('name', 'id');
          
          $rating_options = Rating::lists('name', 'id');
          
          $cast_array = explode(",",$title['actors']);
          $directors_array = explode(",",$title['directors']);
          $producers_array = explode(",",$title['producers']);
          $writers_array = explode(",",$title['writers']);
          $awards_array = explode(",",$title['awards']);
          
          // Unpack serialized runtimes
          if ($title['runtime_serialized'] != '')
          {
              $title['runtimes'] = unserialize($title['runtime_serialized']);
          }
          else
          {
              $title['runtimes'][0] = array('episode_cnt' => $title['episode_cnt'],'runtime_minutes_cnt' => $title['runtime_minutes_cnt']);    
          }          
          
          $data = array("title" => $title,
                        "actors" => $cast_array,
                        "directors" => $directors_array,
                        "producers" => $producers_array,
                        "writers" => $writers_array,
                        "awards" => $awards_array,
                        "genres" => $genres
                   );
          
          //return View::make('titles.edit-title')->with('data', $data);
          return View::make('titles.edit-title-info', compact('network_options','language_options','rating_options'))->with('data', $data);

    }

    public function title_has_this_genre( $genre_id, $title ) {
        if ( is_array( $title['genre'] )) {
            foreach ( $title['genre'] as $genre ) {
               if ( $genre['id'] == $genre_id ) {
                   return true;
               }
            }
        }
        return false;
       
    }
    
    
    public function postStore()
    {
        $validator = Validator::make(
                 Input::all(), array(
                'name' => 'required',
                'synopsis' => 'required',
                'safelist_id' => 'required',
                'episode_cnt' => 'required',
                'runtime_minutes_cnt' => 'required',
                'genres' => 'required',
                'rating' => 'required',
                'production_year' => 'required',
                'producttype_id' => 'required'
                )
          );

        $minutes  = Input::get("runtime_minutes_cnt");
        $count    = Input::get("episode_cnt");
        $runtimes = array();

        if (is_array($minutes))
        {
            for ($index = 0;$index < count($minutes);$index++)
            {
                if (intval($minutes[$index]) != 0)
                {
                    $runtimes[] = array('runtime_minutes_cnt' => $minutes[$index],'episode_cnt' => $count[$index]);
                }
            }
        }

        $data = Input::all();
        
        $title_id = $data['title_id'];
        
        if ($validator->fails())
        {
            return Redirect::to('/title/edit/' . $title_id)->withErrors($validator)->with('data', $data);
        }
         
         $genres = Input::get('genres');
         
         
         // if FILE input fields exist, 
         //       then add new Media records and sync them
         
         $title_id = Input::get("title_id");
         
         $title = Title::find($title_id);
         
         $title->name = Input::get("name");
         
         //error_log( $title->name);
         
         $title->production_year = Input::get("production_year");
         $title->d2 = Input::get("d2");
         $title->d3 = Input::get("d3");
         $title->synopsis = Input::get("synopsis");
         $title->network_id = Input::get("network");
         $title->rating_id = Input::get("rating");
         $title->language_id = Input::get("language");
         $title->original_air_date = Input::get("original_air_date");
         $title->theatrical_release_date = Input::get("theatrical_release_date");
         $title->color = Input::get("color");
         $title->safelist_id = Input::get("safelist_id");
         $title->runtime_minutes_cnt = $minutes[0];
         $title->episode_cnt = $count[0];
         $title->runtime_serialized = serialize($runtimes);
         $title->actors = Input::get("actors");
         $title->directors = Input::get("directors");
         $title->writers = Input::get("writers");
         $title->producers = Input::get("producers");
         $title->awards = Input::get("awards");
         $title->genre()->sync($genres);

         $title->save();
         
         
         $genres = Input::get('genres');
         $title->genre()->sync($genres);
                                    
         // Create a new producer model from values
         // --------------------------------------
          
         if ( $mode = Input::has('save_media_mode') ) // User clicked on Add Media button, so next page is Add Media to Title page
         {
             $new_title_id = $title->id;
             return Redirect::to('/title/editmedia/' . $title_id);
         }
         else                                        // User clicked Save, thus at this point, title is saved, so just exit back to Title Listing
         {
             Session::flash('saved_title_message', 'Successfully saved Title, ' . $title->name . '!');
             return Redirect::to('/title/details/' . $title_id);
         }
         
         
         
    } 
	  
	
	
	public function getCreate()
    {
          // prepare data for genre chooser widget, as well as for directors, writers, etc.. 
          
          $genres = Genre::get(array('id', 'name'))->toArray(); 
          
          $data = array(
              'genres' =>  $genres
          );
          
          $network_options = Network::lists('name', 'id');
          
          $language_options = Language::lists('name', 'id');
          
          $rating_options = Rating::lists('name', 'id');
          
          // dd($data);
          
          return View::make('titles.add-title-info', compact('network_options','language_options', 'rating_options'))->with('data', $data);    
    
    }
    
    public function postStorecreate()
    {
        
        // Create a new title model from values
        // --------------------------------------
       // error_log(print_r(Input::all() ,true));
       
        $validator = Validator::make(
                 Input::all(), array(
                'name' => 'required',
                'synopsis' => 'required',
                'safelist_id' => 'required',
                'episode_cnt' => 'required',
                'runtime_minutes_cnt' => 'required',
                'genres' => 'required',
                'rating_id' => 'required',
                'production_year' => 'required',
                'producttype_id' => 'required'
                
                )
          );
        
        $minutes  = Input::get("runtime_minutes_cnt");
        $count    = Input::get("episode_cnt");
        $runtimes = array();

        if (is_array($minutes))
        {
            for ($index = 0;$index < count($minutes);$index++)
            {
                if (intval($minutes[$index]) != 0)
                {
                    $runtimes[] = array('runtime_minutes_cnt' => $minutes[$index],'episode_cnt' => $count[$index]);
                }
            }
        }
        
        $data = Input::all();
        
        if ($validator->fails())
        {
            return Redirect::to('/title/create')->withErrors($validator)->with('data', $data);
        }
        

          $title_name = Input::get('name');  // could've just passed Input::all() to create, so doh! on me
          $title = Title::create(
                             array(
                               'name' => Input::get('name'),
                               'synopsis' => Input::get('synopsis'),
                               'safelist_id' => Input::get('safelist_id'),
                               'directors' => Input::get('directors'),
                               'producers' => Input::get('producers'),
                               'actors' => Input::get('actors'),
                               'writers' => Input::get('writers'),
                               'awards' => Input::get('awards'),
                               'producttype_id' => Input::get('producttype_id'),
                               'rating_id' => Input::get('rating_id'),
                               'production_year' => Input::get('production_year'),
                               'network_id' => Input::get('network'),
                               'language_id' => Input::get('language'),
                               'final_title' => 1,
                               'color' => Input::get('color'),
                               'd2' => Input::get('d2'),
                               'd3' => Input::get('d3'),
                               'runtime_minutes_cnt' => $minutes[0],
                               'episode_cnt' => $count[0],
                               'runtime_serialized' => serialize($runtimes),
                               'status_id' => 4     // by default, unpublished status
                                ));
        
        $genres = Input::get('genres');
        $title->genre()->sync($genres);
                                    
        // Create a new producer model from values
        // --------------------------------------
          
        if ( $mode = Input::has('add_media_mode') ) // User clicked on Add Media button, so next page is Add Media to Title page
        {
            $new_title_id = $title->id;
            return Redirect::to('/title/addmedia/' . $new_title_id);
        }
        else                                        // User clicked Save, thus at this point, title is saved, so just exit back to Title Listing
        {
            Session::flash('saved_title_message', 'Successfully saved Title, ' . $title_name . '!');
            return Redirect::to('/title/list');
        }
          
          
    }
    
     public function getEditmedia($title_id = 0)
    {
          if ( !$title_id  )
          {
               return Redirect::to("/");
          }

        $title_db = Title::with(array("gallery_image", "billboard_image", "video"))->find($title_id);
        if (!is_object($title_db)) {
            return Redirect::to("/");
        }
        $title = $title_db->toArray();

        $relative_base_url = Config::get('nbc.imageRootImagePath');  //this should be:  /media/shared/assets/images/, for purposes of rendering the uploaded image in realtime after choosing file from operating system
          $relative_video_base_url = Config::get('nbc.imageRootLocalVideoPath');;
          $remote_video_base_url = Config::get('nbc.imageRootVideoPath');
          if (!$relative_video_base_url && strpos($remote_video_base_url,'://') === false) {
              $relative_video_base_url = $remote_video_base_url;
          }

         // dd($title);
           
          if ( count($title['gallery_image']) > 0 && isset($title['gallery_image']['0']['file'] )) {
              $gallery_image_path = asset($relative_base_url . $title['gallery_image'][0]['file']);
              
          } else {
              $gallery_image_path = "Gallery image not set";
              $gallery_image_path = asset('images/publicThumb.jpg');
          }
          
          if ( count($title['billboard_image']) > 0 && isset($title['billboard_image']['0']['file'] )) { 
              $billboard_image_path = asset($relative_base_url . $title['billboard_image'][0]['file']);
              
          } else {
              $billboard_image_path = "billboard image not set";
              $billboard_image_path = asset('images/publicThumb.jpg');
          }

          $videos = $title['video'];
          foreach ($videos as $idx => $video) {
              $videos[$idx]['path'] = file_exists($_SERVER['DOCUMENT_ROOT'].$relative_video_base_url.$video['file']) ? $relative_video_base_url : $remote_video_base_url;
          }
//          if ( count($title['video']) > 0 && isset($title['video']['0']['file'] )) {
//             $video_path = asset($relative_video_base_url . $title['video'][0]['file']);
//             $video_type = $this->getVideoType($title['video'][0]['file']);
//          }

          return View::make('titles.edit-title-media',  compact('gallery_image_path','billboard_image_path','videos'))->with('title_id', $title_id);
    }
    
    
    public function getAddmedia($title_id = 0)
    {
          if ( !$title_id  )
          {
               return Redirect::to("/");
          }
          
          $video_path = "";
          $video_type = "video/webm";
          
          return View::make('titles.add-title-media', compact('video_path', 'video_type'))->with('title_id', $title_id);
    }
   
    /* 
      This method is called upon either dragging an image to the Popup box, or selecting the Upload button
       and using File Dialog box to select a file for upload.  
       
      ( If you're looking for method that's called when you click the Preview and Publish button 
          it's below:  postSavemedia() )
    */    

       
    public function postSavemediafiles($title_id=null)
    {


        if (Input::hasFile('upload_media_file'))
        {
            $destination_path = public_path() . Config::get('nbc.imageRootLocalPath');  // i.e.  c:\xamp\htdocs\laravel\www\public/media/shared/assets/images/,
            $relative_base_url = Config::get('nbc.imageRootLocalPath');  //this should be:  /media/shared/assets/images/, for purposes of rendering the uploaded image in realtime after choosing file from operating system
//            error_log ("dest: $destination_path, rel: $relative_base_url");
            $mediafile = Input::hasFile('upload_media_file');
            $input = array('image' => $mediafile);
        
            $rules = array(
                'upload_media_file' => 'image'
            );
            $validator = Validator::make($input, $rules);
            if ( $validator->fails() )
            {
                return Response::json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
     
            }
            else {
        
               // Set media table field values
               // ----------------------------
                $selected_index = Input::get("media_select");
                
                switch ($selected_index) {
                    case 1:  
                         $mediatype_id = 5;
                         break;
                    case 2:  
                         $mediatype_id = 1;
                         break;
                    case 3:  
                         $mediatype_id = 3;
                         break;
                }
               
                $filename = Input::file('upload_media_file')->getClientOriginalName();
         
                try 
                {
                    $destination_filename =  md5(microtime()) . "_" . str_replace(" ", "-",$filename );

                    Input::file('upload_media_file')->move($destination_path, $destination_filename);

                } 
                catch(Exception $e) 
                {
//                     error_log( $e->getMessage() );
                     return Response::json(['success' => false, 'message' => $e->getMessage()]);
                
                }  
            
                return Response::json(['success' => true, 
                                        'mediatype' => $mediatype_id, 
                                        'file' => asset($relative_base_url . $destination_filename), 
                                        'abs_path' =>  $destination_path . $destination_filename, 
                                        'filename' => $destination_filename,
                                        'orig_filename' => $filename]
                                     );
        
           }
        
        }  
        else if ( Input::hasFile('upload_video_file')) 
        {
            $videofile_path = "/media/shared/assets/videos/";
            $destination_path = public_path() . $videofile_path; 
            $relative_base_url = $videofile_path; 
            
            $filename = Input::file('upload_video_file')->getClientOriginalName();

            try
            {
                $destination_filename =  md5(microtime()) . "_" . str_replace(" ", "-",$filename );

                Input::file('upload_video_file')->move($destination_path, $destination_filename);

                $media_rec = new Media;
                $media_rec->mediatype_id = 6;
                $media_rec->file = $destination_filename;
                $media_rec->status_id = 5;
                $media_rec->description = "Promo Video";

                $media_rec->save();

                $media_id = $media_rec->id;

//                $media_title_rec = new MediaTitle;

//                $media_title_rec->media_id = $media_id;
//                $media_title_rec->title_id = Input::get('title_id');

//                $media_title_rec->save();

            }
            catch(Exception $e) 
            {
//                 error_log( $e->getMessage() );
                 return Response::json(['success' => false, 'message' => $e->getMessage()]);
            
            }  
            
            return Response::json(['success' => true, 
                                    'mediatype' => 6, //
                                    'file' => asset($relative_base_url . $destination_filename), 
                                    'abs_path' =>  $destination_path . $destination_filename, 
                                    'filename' => $destination_filename,
                                    'orig_filename' => $filename,
                                    'id' => $media_id]);
            
            
        }
        
     
    }
/*
    public function postDeletemediavideo() {
        $media_id = Input::get('vid');
        if ($media_id) {
            $rec = MediaTitle::where('media_id','=',$media_id);
            $rec->delete();
            return Response::json(['success' => true]);
        }
        return Response::json(['success' => false]);
    }
*/
    /* This is the method that is called when you click the Preview and Publish button */
     public function postSavemedia()
    {

//      error_log(print_r(Input::all() ,true));
     
        
        $title_id = Input::get("title_id"); // Gets this from a hidden input 
        
        if (Input::has('billboard_filename'))
        {
            $billboard_filename = Input::get("billboard_filename");
            
            try 
            {
                $billboard_imagefile = new Media(array('file' => $billboard_filename, 'mediatype_id' => 5, 'status_id' => 0, 'mediatarget_id' => 3, 'additional' => 0));
                Title::find($title_id)->media()->save($billboard_imagefile);

            } 
            catch(Exception $e) 
            {
//                 error_log( $e->getMessage() );

            }            
        
        } 
        
        if (Input::has('gallery_filename'))
        {
            $gallery_filename = Input::get("gallery_filename");
            
            try 
            {
                $gallery_imagefile = new Media(array('file' =>  $gallery_filename, 'mediatype_id' => 1, 'status_id' => 0, 'mediatarget_id' => 3, 'additional' => 0));
                Title::find($title_id)->media()->save($gallery_imagefile);
            } 
            catch(Exception $e) 
            {
//                 error_log( $e->getMessage() );

            }            
        
        }
        
        if (Input::has('video_filename0'))
        {
            $video_filename = Input::get("video_filename0");
            try 
            {
                $video_imagefile = new Media(array('file' =>  $video_filename, 'mediatype_id' => 6, 'status_id' => 4, 'mediatarget_id' => 3, 'additional' => 0));
                Title::find($title_id)->media()->save($video_imagefile);
            } 
            catch(Exception $e) 
            {
//                 error_log( $e->getMessage() );

            }            
        }
        
        if (Input::has('video_filename1'))
        {
            $video_filename = Input::get("video_filename1");
//            error_log($video_filename);
            try 
            {
                $video_imagefile = new Media(array('file' =>  $video_filename, 'mediatype_id' => 6, 'status_id' => 4, 'mediatarget_id' => 3, 'additional' => 0));
                Title::find($title_id)->media()->save($video_imagefile);
            } 
            catch(Exception $e) 
            {
//                 error_log( $e->getMessage() );

            }            
        }
        
        if (Input::has('video_filename2'))
        {
            $video_filename = Input::get("video_filename2");
//            error_log($video_filename);
            try 
            {
                $video_imagefile = new Media(array('file' =>  $video_filename, 'mediatype_id' => 6, 'status_id' => 4, 'mediatarget_id' => 3, 'additional' => 0));
                Title::find($title_id)->media()->save($video_imagefile);
            } 
            catch(Exception $e) 
            {
//                 error_log( $e->getMessage() );

            }            
        }
        if (Input::has('video_filename3'))
        {
            $video_filename = Input::get("video_filename3");
            try 
            {
                $video_imagefile = new Media(array('file' =>  $video_filename, 'mediatype_id' => 6, 'status_id' => 4, 'mediatarget_id' => 3, 'additional' => 0));
                Title::find($title_id)->media()->save($video_imagefile);
            } 
            catch(Exception $e) 
            {
//                 error_log( $e->getMessage() );

            }            
        }
        
        if (Input::has('video_filename4'))
        {
            $video_filename = Input::get("video_filename4");
            try 
            {
                $video_imagefile = new Media(array('file' =>  $video_filename, 'mediatype_id' => 6, 'status_id' => 4, 'mediatarget_id' => 3, 'additional' => 0));
                Title::find($title_id)->media()->save($video_imagefile);
            } 
            catch(Exception $e) 
            {
//                 error_log( $e->getMessage() );

            }            
        }

        if (Input::has('video_add')) {
            $video_add_list = Input::get('video_add');
            if (is_array($video_add_list)) {
                foreach ($video_add_list as $video_id) {
                    $media_title_rec = new MediaTitle;

                    $media_title_rec->media_id = $video_id;
                    $media_title_rec->title_id = $title_id;

                    $media_title_rec->save();
                }
            }
        }

        if (Input::has('video_delete')) {
            $video_delete_list = Input::get('video_delete');
            if (is_array($video_delete_list)) {
                foreach($video_delete_list as $video_id) {
                    $rec = MediaTitle::where('media_id','=',$video_id)->where('title_id','=',$title_id);
                    if ($rec) {
                        $rec->delete();
                    }
                }
            }
        }

        if (Input::has('preview_publish'))    // Admin clicks Preview/Publish button
        {
            return Redirect::to('/title/previewtitle/' . $title_id); 
        }
        else                                 // Admin just wants to save it for now, and get back to this later
        {
            return Redirect::to('/title/list');
        }
            
      
        
    }
    
    
    // wanted to just use Delete verb, but jquery warned about incompatibilities
    public function postDeletemediafile()
    {
        $media_file_path = Input::get("fullpath"); 
        
        File::delete($media_file_path);
        
    }
    
  
    
    public function getRequest($title_id = 0)
    {
          if ( !$title_id  )
          {
               Redirect::to("/");
          }


          $title_db = Title::with(array("gallery_image"))->find($title_id);
          if (!is_object($title_db)) {
              return Redirect::to("/");
          }
          $title = $title_db->toArray();

          if ( count($title['gallery_image']) > 0)  {
              $gallery_image_path = Config::get('nbc.imageRootImagePath') .  $title['gallery_image'][0]['file'];
          } else {
              $gallery_image_path = "/images/x-image-placeholder.png";
          }
          $fullpath_to_gallery_image = $gallery_image_path;
                     
          //var_dump($title);exit;
          
          $data = array("title" => $title,
                        'gallery_image_path' => $fullpath_to_gallery_image);
          
          return View::make('titles.request')->with('data', $data);
    }

    public function postRequest()
    {
        $success = false;

        if (Input::has('title_id')) {
            $user = Auth::user()->toArray();
            $title_db = Title::with(array("gallery_image"))->find(Input::get('title_id'));
            $sales_db = User::where('client_user_id','=',$user['id'])->where('users_clients_sales.status_id','!=',6)->join('users_clients_sales','users.id','=','sales_user_id')->get();
            if (is_object($title_db) && is_object($sales_db)) {

                $title = $title_db->toArray();
                $sales = $sales_db->toArray()[0];
                $title['image'] = asset(count($title['gallery_image']) > 0 ? Config::get('nbc.imageRootImagePath') .  $title['gallery_image'][0]['file'] : "/images/x-image-placeholder.png");
                $data = array(
                    'title_data' => $title,
                    'client_data' => $user,
                    'sales_data' => $sales,
                    'client_message' =>  Input::get('message'),
                );
                $mail_send_details = [
                    'to_email' => $sales['email'],
                    'from_email' => $user['email'],
                    'subject' => 'Information request from '.$user['name'].' '.$user['surname'],
                    'from' => $user['name'].' '.$user['surname'],
                    ];

                // use Mail::send function to send email passing the data and using the $mail_send_details variable in the closure
                $success = Mail::send('emails.send_info_request', $data, function($message) use ($mail_send_details)
                {

                    $message->from($mail_send_details['from_email'], $mail_send_details['from']);
                    $message->to($mail_send_details['to_email'])->subject($mail_send_details['subject']);

                });
            }
        }
        return $this->makeSuccessArray( ($success ? true : false), array("msg" => $success? "Successful email send" : "Error while sending email"));
    }
    
    public function getPreviewtitle($title_id = 0)
    {
          if ( !$title_id  )
          {
               Redirect::to("/");
          }


          $title_db = Title::with(array("gallery_image", "video", "genre","rating","producttype","favorite"))->find($title_id);
          if (!is_object($title_db)) {
              return Redirect::to("/");
          }
          $title = $title_db->toArray();

          $cast_array = explode(",",$title['actors']);
          $directors_array = explode(",",$title['directors']);
          $producers_array = explode(",",$title['producers']);
          $writers_array = explode(",",$title['writers']);
          $awards_array = explode(",",$title['awards']);

          if (isset($title['gallery_image'][0]))
          { 
          $fullpath_to_gallery_image = Config::get('nbc.imageRootImagePath') . $title['gallery_image'][0]['file'];
          }        
          else
          {
          $fullpath_to_gallery_image = "/images/x-image-placeholder.png";
          }
          $video_file_path_array = array();
          if ( is_array( $title['video'] ) && count($title['video']) > 0) {
              foreach ( $title['video'] as $video ) {
                  $videofile_path = $this->getTitleVideoPath($title['final_title']);
                  $videofile_localpath = Config::get('nbc.imageRootLocalVideoPath');
                  if (!$videofile_localpath && strpos($videofile_path,'://') === false) {
                      $videofile_localpath = $videofile_path;
                  }

                  $fileExists = false;
                  // Get file headers to determine 404
                  if ($videofile_localpath && file_exists($_SERVER['DOCUMENT_ROOT'].$videofile_localpath . $video['file'])) {
                      $fileExists = true;
                      $videofile_path = $videofile_localpath;
                  }
                  if (!$fileExists && $videofile_localpath != $videofile_path && curl_htmlcode($videofile_path . $video['file']) != 404) {
                      $fileExists = true;
                  }

                  if ($fileExists) {
                      $video_file_path_array[] = array("filepath" => $videofile_path . $video['file'], "type" => $this->getVideoType($video['file']), "id" => $video['id'] );
                  }
              }
          }
                     
          //var_dump($title);exit;
          
          $data = array("title" => $title,
                        "mode" => "preview_title",
                         "actors" => $cast_array,
                        "directors" => $directors_array,
                        "producers" => $producers_array,
                        "writers" => $writers_array,
                        "awards" => $awards_array,
                        'gallery_image_path' => $fullpath_to_gallery_image,
                        'video_file_path_array' => $video_file_path_array);
          
          return View::make('titles.preview-title')->with('data', $data);
    }

    
  
  
    
    public function postFinaltitlestage()
    {
       $new_title_id = Input::get("title_id"); // Gets this from a hidden input element      
            
       if ( $mode = Input::has('publish_title') ) // User clicked on Publish Title button, so save it, seting to published and return back to title listing
        {
            $title = Title::find($new_title_id);
            $title->status_id = 3;  // active status in statuses table
            $title->save();
            
            return Redirect::to('/title/list');
            
        }
        else     // User clicked Save however this title is already saved at this point, so just
                 // redirect to title listing page, without setting the status to Active
        {
            return Redirect::to('/title/list');  
        }
     
    }
    
     public function postLogvideoview()
	{
        $title_id = Input::get('title_id');
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $user = User::find($user_id);
        } else {
            $user_id = 0;
            $user = array('region_id' => 0);
        }
        
            $report = Report::create(
                             array(
                                   'date' => time(),
                                   'action_type' =>  12,
                                    'action_user_id' => $user_id,
                                    'object_id' =>  $title_id,
                                    'report_type' => 1,
                                    'aux_object' =>   $user['region_id']
                                  )); 
            $report = Report::create(
                             array(
                                   'date' => time(),
                                   'action_type' =>  12,
                                    'action_user_id' => $user_id,
                                    'object_id' =>  $title_id,
                                    'report_type' => 3,
                                    'aux_object' =>   $user['region_id']
                                  ));                         
 
            
	     if ( $report ) 
	     {
	         return $this->makeSuccessArray( true );
	     } 
	     else
	     {
	         return $this->makeSuccessArray( false, array("msg" => "Error while Report logging" ));
	     }
	    
	}
    
    // ---------------------------------------------------------------
    
    public function postAddfavorite()
	{
	    $user_id = Auth::user()->id;
	    $title_id = Input::get('title_id');
        $action = Input::get('action');
        $user = User::find($user_id);
        
         if ( $action == "add" ) 
         {
             
             $alreadyFavorited = Favorite::where('title_id','=', $title_id)->where('user_id', '=', $user_id)->get()->toArray();
        
             
    	    if ( count($alreadyFavorited) > 0) 
    	    {
    	        return $this->makeSuccessArray( true, array("msg" => "This title is already in your favorites", "alreadyfaved" => true ));
    	    }
	     
	          $id =  DB::table('favorites')->insertGetId(
                                          array(
                                           'title_id' => $title_id,
                                           'user_id' => $user_id
                                          ));
             $report = Report::create(
                             array(
                                   'date' => time(),
                                   'action_type' =>  2,
                                    'action_user_id' => $user_id,
                                     'object_id' =>  $title_id,
                                     'report_type' => 1,
                                     'aux_object' =>   $user['region_id']
                                  )); 
           
            $report = Report::create(
                             array(
                                   'date' => time(),
                                   'action_type' =>  2,
                                    'action_user_id' => $user_id,
                                     'object_id' =>  $title_id,
                                     'report_type' => 3,
                                     'aux_object' =>   $user['region_id']
                                  ));     
         }
         else
         { 
             $id = $affectedRows = Favorite::where('title_id', '=', $title_id)
                                                 ->where('user_id', '=', $user_id)
                                                 ->delete();
         }   
	     if ( $id ) 
	     {
	         return $this->makeSuccessArray( true, array("alreadyfaved" => false ) );
	     } 
	     else
	     {
	         return $this->makeSuccessArray( false, array("msg" => "There was a temporary glitch while favoriting/unfavoriting title, please try again in a moment", "alreadyfaved" => false, "db_log" => DB::getQueryLog() ));
	     }
	    
	}
    


}


