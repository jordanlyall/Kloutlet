<?php

//Parameters in the request from Rapportive to our Raplet
$callback = $_GET['callback'];
$parameters = array();

//Check if the 'show' parameter is set, and is set to 'metadata'
if(isset($_GET['show']) && $_GET['show'] === 'metadata')
	{
                //Yes, 'show' is set to 'metadata'
                // 'metadata' section starts here

                $parameters['name'] = "Kloutlet";
		$parameters['description'] = "Klout + Rapportive = Kloutlet. View the sender's Klout score within Gmail.";
		$parameters['welcome_text'] = "<p>View sender's Klout score. Visit Kloutlet.com for more info.</p>";
		$parameters['icon_url'] = "http://kloutlet.com/images/klout-icon.png";
		$parameters['preview_url'] = "http://kloutlet.com/images/preview.png";
		$parameters['provider_name'] = "Jordan Lyall";
		$parameters['provider_url'] = "http://about.me/jordan/";
		$parameters['data_provider_name'] = "Klout";
		$parameters['data_provider_url'] = "http://www.klout.com";


		$object = $callback."(".json_encode($parameters).")";
	}
	else
        {
               //Nope. 'show' parameter absent, hence, look-up in progress



           
         
             if(isset($_GET['twitter_username']))
             {
 $twitter=$_GET['twitter_username'];                
$json= file_get_contents("http://api.klout.com/1/klout.json?key=ng4r56uqnxjbuh85annkmt64&users=$twitter");

$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($json, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

foreach ($jsonIterator as $key => $val) {
    
        $array = "$key => $val\n";

  
}

$kscore = round($val);

           //Our response
           $parameters['html'] = "<p><a href=\"http://klout.com/".htmlentities($twitter)."\"> <img style=\"padding-right:5px;\" src=\"https://kloutlet.com/images/kloutlet-sq.png\"> ".htmlentities($kscore)." | <span id=\"name\">@".htmlentities($twitter)." </span></a></p> ";

             }
             else
             {
                  $parameters['html'] = "";
             }





 $parameters['css'] = "p{margin:0; padding:0; font-size:13px; color:#605459; font-family: Arial, Helvetica, sans-serif;} #name{color:#2ba0a0; font-weight:none;} img{vertical-align:text-top;}";
           $parameters['js'] = "$('div.info').hide(); $('p.head').click(function(){ $(this).next('div.info').slideToggle(600);});";
           $parameters['status'] = 200;

           //We encode our response as JSON and prepend the callback to it
           $object = $callback."(".json_encode($parameters).")";
         }


echo $object;

?>