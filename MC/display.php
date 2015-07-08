<?php

class Display {
    static function format($text, $idata, $linked = false, $blank_unmatched = true, $collapse = false) {
        $matches = array();
        $matchpattern = '/\\[([-0-9A-Za-z_]*)\\]/';
        $data = (object) $idata;
        $off = 0;
        while (preg_match($matchpattern, $text, $matches, PREG_OFFSET_CAPTURE, $off)) {
            $key = $matches[1][0];
            if ($blank_unmatched || isset($data->{$key}) || defined($key)) {
                $repl = defined($key) ? constant($key) : (isset($data->{$key}) ? (($linked && $data->url) ? '<a href="'.$data->url.'"'.((strpos($data->url,'://')!==false)?' target="_blank"':'').'>' . $data->{$key} . '</a>': $data->{$key}) : '');
                $text = substr_replace($text, $repl, $matches[0][1], strlen($matches[0][0]));
            }
            $off = $matches[0][1] +1;
            $linked = false;
        }
        if ($collapse){
            $tmatches = array();
            while (preg_match('/{([^{}]*)}/',$text,$tmatches,PREG_OFFSET_CAPTURE)){
                $ttx = $tmatches[1][0];
                $tpos = $tmatches[0][1];
                $tl = strlen($ttx);
                $ttx1 = preg_replace("/<[^>]*>/","",$ttx);
                $tlg = preg_match("/[A-Za-z0-9]/",$ttx1);
                $text = substr_replace($text, ($tlg ? $ttx : ""), $tpos, $tl+2);
            }
        }
        return $text;
    }

    static function makeDropdownArray($obj, $key_field, $data_field, $placeholder = false) {
        $da = array();
        if ($placeholder) {
            $da[''] = $placeholder;
        }
        foreach ($obj as $orec) {
            $da[$orec->{$key_field}] = $orec->{$data_field};
        }
        return $da;
    }

    static function getStdValues ($type, $num = false, $placeh = false) {
        $va = Data::where('type','=',$type)
            ->orderBy('serial')
            ->cacheTags('data')->remember(10080)
            ->get();
        return Display::makeDropdownArray($va, ($num ? 'serial' : 'data_body'), 'data_body', $placeh);
    }

    static function ex($obj,$var)
    {
        return isset($obj->{$var}) ? $obj->{$var} : null;
    }

    static function showDate($stamp) {
        if (($off = strpos($stamp,' ')) === false) {
            return $stamp;
        } else {
            return substr($stamp,0,$off);
        }
    }

    static function getPanels() {
        $pa = Panel::cacheTags('panels')->remember(1440)->get();
        $panel_list = array();
        foreach ($pa as $panel) {
            $panel_list[$panel->slot] = array(
                'img' => $panel->img,
                'text' => $panel->text,
                'link' => $panel->link,
                'title' => $panel->title,
                'updated_at' => display::formatDate($panel->updated_at),
            );
        }
        return $panel_list;
    }

    static function formatDate($idt)
    {
        return date('F j, Y',strtotime($idt));
    }

    static function getUploadImageName($filename) {
        $hash = md5($filename);
        return '/jobboard/upload_files/images/'.substr($hash,0,1).'/'.substr($hash,1,1).'/'.substr($hash,2,1).'/'.$hash.'.'.pathinfo($filename,PATHINFO_EXTENSION);
    }
    static function getUploadThumbName($filename) {
        $hash = md5($filename);
        return '/jobboard/upload_files/images/thumbs/'.substr($hash,0,1).'/'.substr($hash,1,1).'/'.substr($hash,2,1).'/'.$hash.'.'.pathinfo($filename,PATHINFO_EXTENSION);
    }

    static function getUploadResumeName($filename) {
        $hash = md5($filename);
        return '/jobboard/upload_files/docs/'.substr($hash,0,1).'/'.substr($hash,1,1).'/'.substr($hash,2,1).'/'.$hash.'.'.pathinfo($filename,PATHINFO_EXTENSION);
    }
}
