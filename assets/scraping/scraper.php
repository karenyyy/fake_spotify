<?php


function playlist_scraper($scrape_site, $url, $p, $delimiter)
{

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, 0);

    $result = curl_exec($curl);
    //print_r($result);
    preg_match_all($p, $result, $match);

    $mv_link = $scrape_site . trim(explode($delimiter."=", $match[0][1])[1], "\"");

    $playlist = explode("list=", $mv_link)[1];
    $playlist = "https://www.youtube.com/playlist?list=" . $playlist;

    curl_close($curl);
    return $playlist;

}


function song_scraper($scrape_site, $url, $p, $delimiter)
{
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, 0);

    $result = curl_exec($curl);
    preg_match_all($p, $result, $match);

    $song_array = array();

    $i=2;
    while (sizeof($song_array)<18) {
        $mv_link = $scrape_site . trim(explode($delimiter . "=", $match[0][$i])[1], "\"");

        array_push($song_array, $mv_link);
        $i+=2;


    }

    curl_close($curl);
    return $song_array;

}


function scrape_tags_per_song($url, $p){

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, 0);

    $result = curl_exec($curl);
    print_r($result);
    preg_match_all($p, $result, $match);
    $tags_array = array();
    $i=0;
    while (sizeof($tags_array)<30) {
        $tags = explode("-video-id=", $match[0][$i])[0];
        preg_match_all("!\".*\"!", $tags, $tags_match);
        array_push($tags_array, str_replace("\"", "",$tags_match[0][0]));
        $i+=1;
    }
    return $tags_array;

}

function scrape_image_per_song($tags, $p, $delimiter){
    $search_string = $tags;
    $url = "https://www.youtube.com/results?search_query=".$search_string;

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, 0);

    $result = curl_exec($curl);
    preg_match_all($p, $result, $match);
    return str_replace("\"", "", explode($delimiter, $match[0][0])[1]);

}


function main(){
    $scrape_site = "https://www.youtube.com";
    $search_string = "billboard+top+50+this+week";
    $url = "https://www.youtube.com/results?search_query=".$search_string;


    $pattern = "!href=\"\/watch\?[a-z]=[A-Za-z0-9]+&amp;list=[A-Za-z0-9]+\"!";

    $pattern2 = "!href=\"\/watch\?[a-z]=[A-Za-z0-9-]+(&amp;|index=[0-9]*|list=[A-Za-z0-9-]+|[a-z]+=[a-z0-9]+)*\"!";

    $pattern3 = "!data-title=\"(.*)\"!";

    $pattern4 = "!src=\"https:\/\/i\.ytimg\.com\/[a-z]+\/[A-Za-z0-9]+\/[A-Za-z0-9]+\.jpg\?([a-z]+=[-_a-zA-Z0-9]+|=&amp;)*\"!";


    $playlist=playlist_scraper($scrape_site, $url, $pattern, "href");
    $song_array = song_scraper($scrape_site, $playlist, $pattern2, "href");
    $tags_array = scrape_tags_per_song($playlist, $pattern3);

    $final_array = array();
    foreach ($song_array as $mv_link) {
        preg_match_all("!index=[0-9]*!", $mv_link, $index);

        $index = explode("=", $index[0][0])[1];
        $song_tag = $tags_array[$index - 1];
        $song_tag = str_replace(">", "", $song_tag);
        $song_tag = str_replace("'", "", $song_tag);
        $song_tag = implode("+", explode(" ", $song_tag));
        $mv_image = scrape_image_per_song($song_tag, $pattern4, "src=");
        array_push($final_array, array(str_replace("+", " ", $song_tag), $mv_link, $mv_image));
    }
    return $final_array;
}


function vevo_scrape($url, $xpath) {
    $html = file_get_contents($url);
    print_r($html);
    $dom = new DOMDocument();
    @$dom->loadHTML($html);
    $finder = new DOMXPath($dom);
    $result = $finder->query($xpath);
    print_r($result);
    return $result->item(0)->nodeValue;
}


function vevo_cover_scrape($url, $xpath){
    $html = file_get_contents($url);
    $dom = new DOMDocument();
    @$dom->loadHTML($html);
    $finder = new DOMXPath($dom);
    $result = $finder->query($xpath);
    return 'https:'.$result->item(0)->nodeValue;
}

function vevo_video_scrape($url, $xpath){
    $html = file_get_contents($url);
    $dom = new DOMDocument();
    @$dom->loadHTML($html);
    $finder = new DOMXPath($dom);
    $result = $finder->query($xpath);
    return 'https://www.vevo.com'.$result->item(0)->nodeValue;

}

function vevo_run()
{
    $vevo_trending_array = array();
    for ($j=1; $j<3; $j++) {
        for ($i = 1; $i < 37; $i++) {
            $tag = vevo_scrape('https://www.vevo.com/trending-now?page='.$j, '/html/body/div[2]/div/div/div[4]/div/div[3]/ul/li[' . $i . ']/div[1]//text()');
            $img = vevo_cover_scrape('https://www.vevo.com/trending-now?page='.$j, '/html/body/div[2]/div/div/div[4]/div/div[3]/ul/li['. $i. ']/a/div/div/picture/img//@src');
            $video = vevo_video_scrape('https://www.vevo.com/trending-now?page='.$j, '/html/body/div[2]/div/div/div[4]/div/div[3]/ul/li['.$i.']/a//@href');
            array_push($vevo_trending_array, array($tag, $img, $video));
        }
        print_r($vevo_trending_array);
    }
    return $vevo_trending_array;
}




function vevo_genre($genre) {
    $vevo_genre_array = array();
    for ($j=1; $j<3; $j++) {
        for ($i = 1; $i < 37; $i++) {
            $artist = vevo_scrape('https://www.vevo.com/genres/'.$genre.'/trending-videos?page='.$j, '/html/body/div[2]/div/div/div[4]/div/div[3]/ul/li[' . $i . ']/div[1]//text()');
            $songtitle = vevo_scrape('https://www.vevo.com/genres/'.$genre.'/trending-videos?page='.$j, '/html/body/div[2]/div/div/div[4]/div/div[3]/ul/li['. $i .']/div[1]/a[2]//text()');
            $img = vevo_cover_scrape('https://www.vevo.com/genres/'.$genre.'/trending-videos?page='.$j, '/html/body/div[2]/div/div/div[4]/div/div[3]/ul/li['. $i. ']/a/div/div/picture/img//@src');
            $video = vevo_video_scrape('https://www.vevo.com/genres/'.$genre.'/trending-videos?page='.$j, '/html/body/div[2]/div/div/div[4]/div/div[3]/ul/li['.$i.']/div[1]/a[2]//@href');
            array_push($vevo_genre_array, array($artist, $songtitle, $img, $video));
        }
        print_r($vevo_genre_array);
    }
    return $vevo_genre_array;
}


function vevo_artist_scrape(){
    $vevo_artist_array = array();
    for ($j = 30; $j < 50; $j++) {
        $each_artist_array=array();
        $name = vevo_scrape('https://www.vevo.com/artists', '/html/body/div[2]/div/div/div[4]/div/div[3]/ul/li[' . $j . ']/div[1]/a//text()');
        $img = vevo_cover_scrape('https://www.vevo.com/artists', '/html/body/div[2]/div/div/div[4]/div/div[3]/ul/li['. $j. ']/a/div/div/picture/img//@src');
        array_push($each_artist_array, $name, $img);
        $name = implode("-", explode(" ", $name));
        for ($i = 1; $i < 8; $i++) {
            $song_artist = vevo_scrape('https://www.vevo.com/artist/'.strtolower($name), '/html/body/div[2]/div/div/div[4]/div/div[3]/div[2]/div/div/div[2]/div/div[' . $i . ']/a/div[2]/div[1]//text()');
            $song_title  = vevo_scrape('https://www.vevo.com/artist/'.strtolower($name), '/html/body/div[2]/div/div/div[4]/div/div[3]/div[2]/div/div/div[2]/div/div[' . $i . ']/a/div[2]/div[2]//text()');
            $cover = vevo_cover_scrape('https://www.vevo.com/artist/'.strtolower($name), '/html/body/div[2]/div/div/div[4]/div/div[3]/div[2]/div/div/div[2]/div/div['. $i. ']/a/div/div/picture/img//@src');
            $video = vevo_video_scrape('https://www.vevo.com/artist/'.strtolower($name), '/html/body/div[2]/div/div/div[4]/div/div[3]/div[2]/div/div/div[2]/div/div['.$i.']/a//@href');
            array_push($each_artist_array, array($song_artist, $song_title, $cover, $video));
        }
        print_r($each_artist_array);
        $fp = fopen('vevo_popular_artists.json', 'a');
        fwrite($fp, json_encode($each_artist_array, JSON_PRETTY_PRINT));
        array_push($vevo_artist_array, $each_artist_array);
//        print_r($vevo_artist_array);
    }
    return $vevo_artist_array;
}






//Genres
//$genre_array = ['pop', 'hip-hop','country','electronic','rock','latino','rbsoul'];

//
//foreach ($genre_array as $item) {
//    $vevo_genre_array = vevo_genre($item);
//    $fp = fopen('../json_files/vevo_'.$item.'.json', 'w');
//    fwrite($fp, json_encode($vevo_genre_array, JSON_PRETTY_PRINT));
//    fclose($fp);
//}

//$vevo_artist_array = vevo_artist_scrape();
//$fp = fopen('vevo_popular_artists.json', 'a');
//fwrite($fp, json_encode($vevo_artist_array, JSON_PRETTY_PRINT));
//fclose($fp);
//$final_array = main();
//$fp = fopen('scraped_results.json', 'w');
//fwrite($fp, json_encode($final_array, JSON_PRETTY_PRINT));
//fclose($fp);

//
//function resize_image($file, $w, $h, $specific=false, $crop=false) {
//    list($width, $height) = getimagesize($file);
//    $r = $width / $height;
//    if ($crop) {
//        if ($width > $height) {
//            $width = ceil($width-($width*abs($r-$w/$h)));
//        } else {
//            $height = ceil($height-($height*abs($r-$w/$h)));
//        }
//        $newwidth = $w;
//        $newheight = $h;
//    } else {
//        if ($w/$h > $r) {
//            if ($specific){
//                $newwidth = $w;
//                $newheight = $h;
//            }else{
//                $newwidth = $h*$r;
//                $newheight = $h;
//            }
//
//        } else {
//            if ($specific) {
//                $newheight = $h;
//                $newwidth = $w;
//            }else{
//                $newheight = $w / $r;
//                $newwidth = $w;
//            }
//        }
//    }
//    $src = imagecreatefromjpeg($file);
//    $dst = imagecreatetruecolor($newwidth, $newheight);
//    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
//
//    return $dst;
//}


//define('DIRECTORY', '/opt/lampp/htdocs/fake_spotify/assets/images');
//
//$content = file_get_contents('https://elrescatemusical.com/wp-content/uploads/2017/11/amas.jpg');
//file_put_contents(DIRECTORY . '/top.jpg', $content);
//$img = resize_image(DIRECTORY . '/top.jpg', 800, 400, true);
//imagejpeg($img,DIRECTORY . '/top.jpg');
//

?>


