<?php
    function sanitize_output($buffer) {
    
    	$search = array(
    		'/\>[^\S ]+/s',
    		'/[^\S ]+\</s',
    		'/(\s)+/s'
    	);
    
    	$replace = array(
    		'>',
    		'<',
    		'\\1'
    	);
    
    	$buffer = preg_replace($search, $replace, $buffer);
    
    	return $buffer;
    }
    
    ob_start("sanitize_output");
?>
<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>iTunes Top <?php if(!array_key_exists('c',$_GET) || $_GET['c']==5) echo 5; else echo $_GET['c']; ?></title>
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
        <link href="main.css" type='text/css' rel="stylesheet">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            jQuery(document).bind('keyup', function(e) {
            	if(e.which==39){
            		jQuery('a.carousel-control.right').trigger('click');
             	}   
            	else if(e.which==37){
            		jQuery('a.carousel-control.left').trigger('click');
             	}
            });
        </script>
    </head>
    <body>
        <div id="wrapper">
            <div id='container'>
                <h1>iTunes Top <?php if(!array_key_exists('c',$_GET) || $_GET['c']==5) echo 5; else echo $_GET['c']; ?></h1>
                <!-- <small>1.0</small> -->
                <div id='return' style='display: none;'></div>
                <h4>How many would you like?</h4>
                <div class="btn-group">
                    <?php if(!array_key_exists('c',$_GET) || $_GET['c']==5):?><a href="?c=5" class="btn btn-default active">5</a><?php else:?><a href="?c=5" class="btn btn-default">5</a><?php endif?>
                    <?php if($_GET['c']==10):?><a href="?c=10" class="btn btn-default active">10</a><?php else:?><a href="?c=10" class="btn btn-default">10</a><?php endif?>
                    <?php if($_GET['c']==15):?><a href="?c=15" class="btn btn-default active">15</a><?php else:?><a href="?c=15" class="btn btn-default">15</a><?php endif?>
                    <?php if($_GET['c']==20):?><a href="?c=20" class="btn btn-default active">20</a><?php else:?><a href="?c=20" class="btn btn-default">20</a><?php endif?>
                    <?php if($_GET['c']==25):?><a href="?c=25" class="btn btn-default active">25</a><?php else:?><a href="?c=25" class="btn btn-default">25</a><?php endif?>
                    <?php if($_GET['c']==30):?><a href="?c=30" class="btn btn-default active">30</a><?php else:?><a href="?c=30" class="btn btn-default">30</a><?php endif?>
                    <?php if($_GET['c']==35):?><a href="?c=35" class="btn btn-default active">35</a><?php else:?><a href="?c=35" class="btn btn-default">35</a><?php endif?>
                    <?php if($_GET['c']==40):?><a href="?c=40" class="btn btn-default active">40</a><?php else:?><a href="?c=40" class="btn btn-default">40</a><?php endif?>
                    <?php if($_GET['c']==45):?><a href="?c=45" class="btn btn-default active">45</a><?php else:?><a href="?c=45" class="btn btn-default">45</a><?php endif?>
                    <?php if($_GET['c']==50):?><a href="?c=50" class="btn btn-default active">50</a><?php else:?><a href="?c=50" class="btn btn-default">50</a><?php endif?>					
                </div>
                <br /><br />
                <div class='middle'>
                    <div id="songs" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                                if ($_GET['c'] <= 200) {
                                	$c = $_GET['c'];
                                	if(!array_key_exists('c',$_GET)) $c = 5;
                                	$topTenArray = json_decode(file_get_contents('https://itunes.apple.com/us/rss/topsongs/limit='.$c.'/json'),true);
                                	$topTenArray = $topTenArray['feed']['entry'];
                                	
                                	$songNames = array();
                                	
                                	$i = 0;
                                	
                                	foreach ($topTenArray as $song) {
                                		$songNames[] = $song['im:name']['label'];
                                		$name = $song['im:name']['label'];
                                		$openInLink = $song['im:collection']['link']['attributes']['href'];
                                		$title = $song['title']['label'];
                                		$price = $song['im:price']['label'];
                                		$currency = $song['im:price']['attributes']['currency'];
                                		$rights = $song['rights']['label'];
                                		$album = $song['im:collection']['im:name']['label'];
                                		$artist = $song['im:artist']['label'];
                                		$artistLink = $song['im:artist']['attributes']['href'];
                                		$image = $song['im:image'][2]['label'];
                                		$genre = $song['category']['attributes']['label'];
                                		$genreLink = $song['category']['attributes']['scheme'];
                                		
                                		if ($i == 0) {
                                			$active = ' active';
                                		}
                                		else {
                                			$active = '';
                                		}
                                		
                                		$num = $i+1;
                                		
                                		echo "
                                			<div class='item".$active."'>
                                			  <div class='container'>
                                			  	<img src='".$image."' class='center' />
                                			  	<p class='center' style='margin-bottom: 20px;'>".$num.'/'.$c."</p>
                                				<table class='table table-striped table-bordered'>
                                				  <tbody>
                                					<tr>
                                						<td>".$title."</td>
                                					  </tr>
                                					  <tr>
                                						<td>".$price.' '.$currency."</td>
                                					  </tr>
                                					  <tr>
                                						<td>".$genre."</td>
                                					  </tr>
                                					  <tr>
                                						<td>".$artist."</td>
                                					  </tr>
                                					  <tr>
                                						<td>".str_replace('?','&copy;',utf8_decode($rights))."</td>
                                					  </tr>
                                					</tbody>
                                				</table>
                                			  </div>
                                			</div>";
                                	
                                		$i++;
                                	}
                                }
                            ?>						
                        </div>
                        <a class='left carousel-control' style='background-image: none;' href='#songs' data-slide='prev'><span class='glyphicon glyphicon-chevron-left'></span></a>
                        <a class='right carousel-control' style='background-image: none;' href='#songs' data-slide='next'><span class='glyphicon glyphicon-chevron-right'></span></a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>