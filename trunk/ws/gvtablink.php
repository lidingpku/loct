<?php

/**
 example usage
 http://data-gov.tw.rpi.edu/ws/gvtab.php?config_uri=http://data-gov.tw.rpi.edu/demo/static/agency-dataset-config.json&query_uri=http://data-gov.tw.rpi.edu/sparql/select_count_agency_from.sparql&show_header=true
 
 the configure file is the key 
 http://data-gov.tw.rpi.edu/demo/static/agency-dataset-config.json
*/

$config_uri = $_GET["config_uri"];

$config = json_decode(file_get_contents($config_uri ));

$show_header =$config->show_header;

$data_uri = $config->data_uri;
if (empty($data_uri)){
        $query_uri =$config->url_query;
        $sparql2json_uri = "http://data-gov.tw.rpi.edu/ws/sparql2json.php";

        $data_uri = sprintf("%s?sparql_uri=%s&format=gvds",
             $sparql2json_uri,
             urlencode($query_uri) );
}
         
if (array_key_exists("debug", $_GET) && $_GET["debug"]){
    echo $query_uri;
    echo "\n--------\n";
    echo $data_uri;
    echo "\n--------\n";
    echo $config_uri;
    echo "\n--------\n";
    echo $show_header;
    echo "\n--------\n";
    print_r ($config) ;
}

show_gvtab($data_uri, $config, $show_header);

function show_gvtab($data_uri, $config, $show_header=false){
   
//show display UI
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>
<?php   
        echo $config->title;  
?>   
        </title>
    
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
                google.load('visualization', '1', {packages: <?php 
        $packages = array();
        foreach($config->packages as $package)
                $packages[] = $package->package;
        $content = json_encode($packages);
        echo str_replace("\"","'", strtolower($content));
?>});
    </script>


    <script type="text/javascript">
    var visualization;

    function drawVisualization() {
		var query = new google.visualization.Query('<?php echo $data_uri; ?>');
		
		// Send the query with a callback function.
		query.send(handleQueryResponse);
    }
    
    function handleQueryResponse(response) {
		if (response.isError()) {
			alert('Error in query: ' + response.getMessage() + ' ' + response.getDetailedMessage());
			return;
		}
		var data = response.getDataTable();
		<?php
		
        foreach($config->packages as $package){
                $type = $package->package;
                echo "var visualization = new google.visualization.". $type."(document.getElementById('visualization_".$type."'));\n";
                if (empty($package->params))
                        $params = "data, null" ;
                else
                        $params = "data, ". $package->params;
                        
                echo "visualization.draw(". $params.");\n";
				
				echo "google.visualization.events.addListener(visualization, 'onmouseover', function(event) {
					visualization.setSelection([event]); });\n";
					
				echo "google.visualization.events.addListener(visualization, 'onmouseout', function(event) {
					visualization.setSelection([{'row': null, 'column': null}]); });\n";
				
				echo "google.visualization.events.addListener(visualization, 'select', function() {
					var row = visualization.getSelection()[0].row;
					var url = data.getValue(row,0);
					window.open(url);
				});\n";
        }
		?>
	}		
    google.setOnLoadCallback(drawVisualization);
    </script>
<?php

        show_tab_css();
        
        if ($show_header){
                require_once("dgtwc-demo-ui.php");
                show_demo_style();
        }
?>  
  </head>
  <body style="font-family: Arial;border: 0 none;">
<?php
        if ($show_header){
                require_once("dgtwc-demo-ui.php");
                show_demo_header($config->title, $config->url_demo,  $config->url_wiki);
        }
?>  
  
 <?php
        echo " <div class=tabs style=\"".$config->tab_style."\">\n";
        foreach($config->packages as $package){
                $type = $package->package;
                echo "  <div id=tab_".$type.">   <a href=\"#tab_".$type."\">".$type."</a>\n";
            echo "<div id=\"visualization_". $type."\" style=\"".$package->style."\"></div>\n";
                echo "  </div>\n";
        }
        echo "  </div>\n";
        
        echo "<hr/>\n";
        echo "<div>";
        echo $config->description;
        echo "</div>";

?>   
  </body>
</html>
<?php

} //end function show_gvtab


function show_tab_css(){
?>

<style type="text/css">
div.example {border: #603 dotted; padding: 0.6em; margin: 1em 2em}

/* First example */
div.items p:not(:target) {display: none}
div.items p:target {display: block}
p.menu {margin: 0; padding: 0.4em; background: silver; color: black}
p.menu a {color: black; border: thin outset silver; padding: 0.1em 0.3em}
div.items p {height: 6em; overflow: auto; text-align: center; margin: 0}
#item1 {color: red}
#item2 {color: green}
#item3 {color: blue}

/* Tabbed example */
div.tabs {
  min-height: 7em;              /* No height: can grow if :target doesn't work */
  position: relative;           /* Establish a containing block */
  line-height: 1;               /* Easier to calculate with */
  z-index: 0}                   /* So that we can put other things behind */
div.tabs > div {
  display: inline}              /* We want the buttons all on one line */
div.tabs > div > a {
  color: black;                 /* Looks more like a button than a link */
  background: #CCC;             /* Active tabs are light gray */
  padding: 0.2em;               /* Some breathing space */
  border: 0.1em outset #BBB;    /* Make it look like a button */
  border-bottom: 0.1em solid #CCC} /* Visually connect tab and tab body */
div.tabs > div:not(:target) > a {
  border-bottom: none;          /* Make the bottom border disappear */
  background: #999}             /* Inactive tabs are dark gray */
div.tabs > div:target > a,      /* Apply to the targeted item or... */
:target #default2 > a {         /* ... to the default item */
  border-bottom: 0.1em solid #CCC; /* Visually connect tab and tab body */
  background: #CCC}             /* Active tab is light gray */
div.tabs > div > div {
  background: #CCC;             /* Light gray */
  z-index: -2;                  /* Behind, because the borders overlap */
  left: 0; top: 1.3em;          /* The top needs some calculation... */
  bottom: 0; right: 0;          /* Other sides flush with containing block */
  overflow: auto;               /* Scroll bar if needed */
  padding: 0.3em;               /* Looks better */
  border: 0.1em outset #BBB}    /* 3D look */
div.tabs > div:not(:target) > div { /* Protect CSS1 & CSS2 browsers */
  position: absolute }          /* All these DIVs overlap */
div.tabs > div:target > div, :target #default2 > div {
  position: absolute;           /* All these DIVs overlap */
  z-index: -1}                  /* Raise it above the others */
</style>
<?php
}
?>
