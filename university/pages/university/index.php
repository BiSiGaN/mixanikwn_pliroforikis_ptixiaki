<?php
/**
 * university index
 *
 */


global $CONFIG;	
$username = elgg_get_logged_in_user_entity()->username;
$get = "SELECT * FROM `{$CONFIG->dbprefix}pt_register` WHERE username='{$username}'";
$datas = university::Data($get, 'get');
foreach($datas as $data)
{
	$mydata_username 		= $data->username;
	$mydata_pt_username 	= $data->pt_username;
	$mydata_password 		= $data->password;
	$mydata_university 		= $data->university;
}

	switch ($mydata_university) {
	
    case "tei lamias":
        $username = $mydata_pt_username;
		$password = $mydata_password;
		$url="https://e-gram.teilam.gr/unistudent/login.asp"; 
		$tei_ratings_url = "https://e-gram.teilam.gr/unistudent/stud_CResults.asp";
        break;
    case "tei xalkidas":
       
        break;
    case "tei patras":
       
        break;
	 case "tei athinas":
       
        break;
	 case "tei spartis":
		$username = $mydata_pt_username;
		$password = $mydata_password;
		$url = 'http://www.webgram.teikal.gr/unistudent/login.asp';
		$tei_ratings_url = "http://www.webgram.teikal.gr/unistudent/stud_CResults.asp?studPg=1&mnuid=mnu3&";
        break;
	default:
       $content = "Error";
}
	

include('simple_html_dom.php');
elgg_register_page_handler('university', 'name');
$title = elgg_echo('University');
header("Content-type: text/html; charset=UTF-8");
$options = array('type' => 'user', 'full_view' => false);
switch ($vars['page']) {
	case 'egram':
		
			$a="%C5%DF%F3%EF%E4%EF%F2";
			$postinfo = "userName=".$username."&pwd=".$password."&submit1=".$a."&loginTrue=login";

			$cookie_file_path = "C:/Users/BiSiGaN /cookie.txt";

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_HEADER, false);

			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

			curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_path);
			//set the cookie the site has for certain features, this is optional
			curl_setopt($ch, CURLOPT_COOKIE, "cookiename=0");
			curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_REFERER, $_SERVER['REQUEST_URI']);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


			//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postinfo);

			curl_exec($ch);

			//page with the content I want to grab
			curl_setopt($ch, CURLOPT_URL, $tei_ratings_url);
			$html = curl_exec($ch);
			curl_close($ch);
			
			$html = str_get_html($html);
			
			$html = $html->find('#mainTable',0);
			$html = str_get_html("$html->innertext");
			$html = $html->find('table',0);
			foreach($html->find('img') as $img)
			{
				$img->tag = 'div';
			}		
			$content = '<table border="0" cellpadding="4" cellspacing="2" width="95%" align="center" id="mainTable">'.$html.'</table>';	
		break;
	case 'announce':
	default:
		if($mydata_university == 'tei lamias')
		{
			$x1 = 0;
			$x2 = 0;
			$html = file_get_html('http://www.inf.teilam.gr/gr/announcements.html');
			foreach($html->find('div#content') as $e)
			{
				foreach($e->find('a') as $c)
				{
				
					$text = $c->innertext;
					$text = iconv("Windows-1253", "UTF-8", $text);

					$x1++;
					$x2++;
					if(substr( $c->href , 0, 7 ) === "http://")
					{

						$content .= '<a href="'.$c->href.'">'.$text.'</a><hr>';
						
					}
					else
					{
						
						$content .= '<a href="http://www.inf.teilam.gr/'.$c->href . '">'.$text.'</a><hr>';
					
					}
				}

			}
		}
		if($mydata_university == 'tei spartis')
		{
			$html = file_get_html('http://www.cs.teikal.gr/index.php/');
			$html = $html->find('div.latestnews', 0);
			foreach($html->find('a') as $a)
			{	
				
				$a->href = 'http://www.cs.teikal.gr'.$a->href;
			}
			foreach($html->find('a.latestnews') as $a)
			{
				$a->tag = 'span';
			}
			foreach($html->find('div.latestnewsitems') as $div)
			{
				$div->outertext = $div.'<hr>';
			}
			
			$content = $html;	
		}
		break;
}

$params = array(
	'content' => $content,
	'sidebar' => elgg_view('university/sidebar'),
	'title' => $title,
	'filter_override' => elgg_view('university/nav', array('selected' => $vars['page'])),
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
