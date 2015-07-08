<?php
   // set the label visibility, i.e, don't show the Producers label if there are
   // no producers, etc, for the remainder of the title attributes
   
 // print_r($data['writers']);
  //exit;
  
   if ( !empty($data['writers'][0]) )
      $writers_label = "WRITERS";
   else
      $writers_label = "";
   
   if ( !empty($data['actors'][0]))
      $cast_label = "CAST";
   else
      $cast_label = "";
      
    if ( !empty($data['awards'][0]))
      $award_label = "AWARDS";
    else
      $award_label = "";    
      
      
   if ( !empty($data['producers'][0]) )
      $producers_label = "PRODUCERS";
   else
      $producers_label = "";
       
  $display_type = '';
  if ( in_array($data['title']['producttype_id'], [10, 14, 16])  ){
      $date_label = "Original US Air Date";
      $date_itself = Date("m/d/y", strtotime($data['title']["original_air_date"]));
      
      if ($data['title']["original_air_date"] == 0) { $display_type = "style='display:none;'"; }
  } else {
      $date_label = "US THEATRICAL RELEASE";
      $date_itself = Date("m/d/y", strtotime($data['title']["theatrical_release_date"]));
      
      if ($data['title']["theatrical_release_date"] == 0) { $display_type = "style='display:none;'"; }
  }

  // PRODUCERS
  // EPISODE COUNT
  // WRITERS
  // 
   
?>
<!doctype html>
<html lang="en">
<head>

<meta charset="UTF-8">
<title>NBCU | The VAULT</title>
@include('partials.header-main-styles')

<script type="text/javascript">
  document.createElement('video');document.createElement('audio');document.createElement('track');
</script>
<link href="//vjs.zencdn.net/4.11/video-js.css" rel="stylesheet">
<script src="//vjs.zencdn.net/4.11/video.js"></script>

<style>
   #more_link {
    cursor: pointer;
   }
   .js-title-detail-about p, .main-page-title{
     font-family: 'Museo Sans', sans-serif;   
   }
</style>

<script type="text/javascript">
  document.createElement('video');document.createElement('audio');document.createElement('track');
</script>

<link href="//vjs.zencdn.net/4.11/video-js.css" rel="stylesheet">
<script src="//vjs.zencdn.net/4.11/video.js"></script>

</head>

<?php $title = $data["title"] ?>

<body id="body">

 <div id="wrapper-new" class="blackBG">

	@include('partials.header-main-nav-new') 	 
     
<div class="container-off-white">
  <!-- start breadcrumb-->
    <div class="container">
		<div class="breadcrumb-NAV">
			<nav class="breadcrumbNBC">
				<?php if($userrole == "admin") : ?>
				<a href="/admin" class="breadCrumGray">Home</a>
				<?php elseif($userrole == "client") : ?>
				<a href="/client" class="breadCrumGray">Home</a>
				<?php else :  ?>
				<a href="/sales" class="breadCrumGray">Home</a>
				<?php endif;  ?>
				<span class="breadcrumb-triangle"></span>
				<a href="/title/list" class="breadCrumGray">All Titles</a>
				<span class="breadcrumb-triangle"></span>
				<a href="/title/details/{{ $title['id'] }}" class="breadcrumb-active">{{ $title['name'] }}</a>
			</nav>
		</div>		
    </div>
</div>

<div class="container-gray breadcrumbNBC-Title">
    <div class="container clearfix">
    	<div class="main-page-title">{{ repair_a_the($title['name']) }}</div>
    	<ul class="l-grid spacing-sm right">
    		<?php if($userrole != "admin") : ?>
    		<?php 
    		  //error_log(print_r($title,true));
    		     if ( count($title['favorite']) ) {
                     $fave_but_class="add-to-text-detailed-faved";
                     $fave_star_class = "add-to-icon-detailed-faved";
                 }
                 else {
                     $fave_but_class="add-to-text";
                     $fave_star_class = "add-to-icon";
                 }
    		?>
    		<li>
    			<a id="favorite_title" href="javascript:void()" class="base-btn primary-btn">
    				<span id="star_{{$title['id']}}" class="{{$fave_star_class}}">★</span>
   					<span id="favspan_{{$title['id']}}" class="{{$fave_but_class}}">FAVORITE</span>
    			</a>
    		</li>
	    		<?php if($userrole != "client") : ?>
	    		<li>
	    			<a href="#" class="base-btn primary-btn" data-toggle="modal" data-target="#add-collection-form">
						<span class="add-to-icon">✚</span>
	   					<span class="add-to-text">COLLECTION</span>
	    			</a>
	    		</li>
	    		<?php endif;  ?>
    		<?php else :  ?>
    		<li>
    			<a href="#" class="base-btn primary-btn">
					<span class="add-to-icon"></span>
   					<span class="add-to-text no-icon" id="edit_title_span">Edit</span>
    			</a>
    		</li>    		
    		<li>
    			<a href="#" class="base-btn primary-btn">
					<span class="add-to-icon"></span>
   					<span class="add-to-text no-icon confirm" id="delete_title_span" >Delete</span>    				
    			</a>
    		</li>    		    		
			<?php endif; ?>
			<?php if($userrole != "client") : ?>
    		<li class="hidden-mobi">
    			<a href="/sellsheet/details/{{ $title['id'] }}" class="base-btn primary-btn">
					<span class="add-to-icon add-to-icon-dot">&#149;</span>
   					<span class="add-to-text">SELL SHEET</span>    				
    			</a>
    		</li>
    		<?php endif; ?>
    	</ul>
    	<?php if($userrole == "client") : ?>
	    	<div class="request-more-info clear"><a href="/title/request/{{ $title['id'] }}">Request More Information </a></div>
	    <?php endif; ?>
    </div>
 </div> 

<div class="form-action-band">
          <div class="error-band">Error</div>
          <div class="success-band">Success</div>
     </div>
 <div class="container-lighBlue min-heightBody">
	<div class="container">
        <div class="row maxH relative col-md-5x">	    
		    <aside class="allTitlesNavBig col-md-7">	
			  <div class="posterBig">
		         <div class="video-wrap">
				    <div id="title-detail-img" class="img-cover">
					      <img src="{{ $data['gallery_image_path'] }}" border="0" alt="large-nail" />
				    </div>
                     <input type="hidden" name="title_id" id="title_id" value="{{$data['title']['id']}}">
<?php foreach ($data['video_file_path_array'] as $video_idx => $video) { ?>
                     <div class="dvd-video-mod" id="title-detail-video-{{ $video_idx }}" style="display:none;">
				      <div class="img-cover">
					      <img src="{{ $data['gallery_image_path'] }}" border="0" alt="large-nail" />

 					<video class="title-detail-video" controls="1" style="background-color:black;" preload="auto" id="video-{{ $video_idx }}">

                        <source src="<?=$video['filepath'] ?>" type='video/<?=$video['type'] ?>'>

 					<p class="vjs-no-js">please enable JavaScript or consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>

					</video>
				      </div>
		    		</div>
<?php } ?>

                     <div class="video-prev-nail nail-cover section-content">
				      	<ul class="l-grid grid-large-3 grid-small-6 clearfix spacing-md">
				        	<li class="video-thumb is-active" onclick="$('.dvd-video-mod').hide();$('#title-detail-img').show();stopCurrentVideo();">
				        		<img src="{{ $data['gallery_image_path'] }}" border="0" alt="sm-nail" data-video="off">
				        	</li>
        		    		<?php
        		    		    foreach ($data['video_file_path_array'] as $video_idx => $video)
        		    		    {
        		    		?>
				        	<li class="video-thumb">
				        		<span class="overlay-video" data-video="on" data-video-thumb-idx="{{ $video_idx }}" data-video-media-id="{{ $video['id'] }}" id="video_thumb_{{ $video_idx }}"></span>
				        		<img src="{{ $data['gallery_image_path'] }}" border="0" alt="sm-nail">
				        	</li>
        		    		<?php
                                }
        		    		?>
				        </ul>
				    </div>
		  		</div>
	          </div>
	      </aside>
      
			<section class="col-md-5">
				 <div class="js-details-all-block clearfix section-content_lrg" style="min-height: 602px;">
				  	<nav class="detail-titles-nav">
				      <ul class="border-tabs l-grid clearfix grid-large-6">
						  <li>
						  	<a data-id="detail-about-handler" href="#" class="border-tabs-active" data-detail="tabs">About</a>
						  </li>
						  <li>
						  	<a data-id="additional-detail-handler" href="#" data-detail="tabs">Additional Details</a>
						  </li>
				      </ul>
				  	</nav> 
				  	<div class="js-title-detail-about">
					  	<div class="row">
					  		<div id="cast_div" class="col-md-6">
					  			<h4 class="primary-title">{{ $cast_label }}</h4>
					  			<p>
					  			 <?php $cnt =  count($data['actors']); 
					  			     $cntr = 0;
					  			 ?>
					  			 
							     @foreach ( $data['actors'] as $actor )
							         {{$actor}}<?php if ( $cntr < $cnt-1 ) {
							           echo ",";
							          } 
							         $cntr++;
							         ?>
							     @endforeach
					  			</p>
					  		</div>
					  		<div id="runtime_div" class="col-md-12">
					  			<h4 class="primary-title"><?php $x = 0; if (isset($data['title']['runtimes'][0]['episode_cnt']) && $data['title']['runtimes'][0]['episode_cnt'] != 0) { echo 'EPISODE COUNT'; } else { echo "RUNTIME"; } ?></h4>
					  		   @foreach ( $data['title']['runtimes'] as $runtime )<?php if ($x != 0) { echo ' '; } $x++; ?>
					  			<p><?php if ($runtime['episode_cnt'] != 0) { ?>{{ $runtime['episode_cnt'] }} x <?php } ?>{{ $runtime['runtime_minutes_cnt']}}</p>
                               @endforeach
					  		</div>
					  		<div id="producers_div" class="col-md-6">
					  			<h4 class="primary-title" style="padding-top:10px;"> {{$producers_label}} </h4>
					  			<p>
					  				 <?php
                                        echo implode(', ',$data['producers']); 
  						             ?>
					  			</p>
					  		</div>
					  		<?php if (count($data['genres']) != 0) { ?>
					  		<div id="genres_div" class="col-md-12">
					  			<h4 class="primary-title">GENRE</h4>
					  			<p>
					  			<?php $cnt =  count($data['genres']); 
					  			  $cntr = 0;
					  		    ?>    
							    @foreach ( $data['genres'] as $genre )
							         {{$genre}}<?php if ( $cntr < $cnt-1 ) {
							           echo ",";
							          }
							           $cntr++;
							            ?> 
							     @endforeach
					  			</p>
					  		</div>
					  		<?php } ?>
							  <div id="about_div" class="col-md-12">
								<h4 class="primary-title">ABOUT</h4>
								
								    <p id="partial_about"></p>
								    <p id="full_about" >{{ $title['synopsis'] }}</p>
								    <span class="primary-title" id="more_link"><img src="/images/ar_down.png" style="vertical-align:text-bottom"> More</span>
							</div>
						</div>
					</div><!-- End title detail about -->

					<div id="title-detail-additional" class="js-title-detail-additional">
						<div class="row">
							<div class="col-md-6">
								<h4 class="primary-title">{{$writers_label}}</h4>
								<p>
								    <?php $cnt =  count($data['writers']);
					  			       $cntr = 0;
					  		        ?>    
									@foreach ( $data['writers'] as $writer )
				         				{{$writer}}<?php if ( $cntr < $cnt-1 ) {
							           echo ",";
							          }
							           $cntr++;
							            ?> 
				     				@endforeach
								</p>
							</div>
							<div class="col-md-6">
								<h4 class="primary-title">PRODUCT TYPE</h4>
								<p>
									{{ $data['title']['producttype']['name']  }}
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<h4 class="primary-title">YEAR</h4>
								<p>
									{{ $data['title']['production_year']  }}
								</p>
							</div>
							<div class="col-md-6">
								<h4 class="primary-title">COLOR</h4>
								<p>
									{{ $data['color']  }}
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<h4 class="primary-title">RATING</h4>
								<p>
									{{ $data['rating'] }}
								</p>
							</div>
							<div class="col-md-6" {{ $display_type }}>
								<h4 class="primary-title">{{$date_label}}</h4>
								<p>
									{{ $date_itself }}
								</p>					
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
						      <h4 class="primary-title">{{$award_label}}</h4>
					  			<p>
					  			<?php $cnt =  count($data['awards']); 
					  			  $cntr = 0;
					  		    ?>    
							    @foreach ( $data['awards'] as $award )
							         {{ $award }}
							     <?php if ( $cntr < $cnt-1 ){?>,
							            <?php } 
							            $cntr++;
							            ?>    
							     @endforeach
					  			</p>
							</div>
							
						</div>
									
					</div><!-- End additional details -->

				</div>
			</section>
	   </div>
	 </div>
 </div> 
  
<div id="footer">
   <div class="container">       
	  @include('partials.new-footer-blade') 	
   </div>
 </div> 

</div><!--end of wrapper-new-->

<form>
  <!-- This is needed for the ajax-driven add-to-collection, add-to-favorite buttons -->
   <input type="hidden" name="title_id" id="title_id" value="{{ $title['id']}}">
</form>

<!-- Add to Collection Form Modal -->

<div class="modal fade" id="add-collection-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
      	<h4 class="title-border">What collection would you like to add the title to?</h4>
      	<div class="input-row">
      		<label for="add-existing-collection">To an existing collection</label>
      		<input id="add-existing-collection" type="radio" name="add-to-collection" checked/>
      		<div class="pretty-select">
      			  {{ Form::select('collections', $data['collections'],  $data['first_collection_id'], array('id'=>'collections_list', 'name'=>'collections') ) }}
      		</div>
      	</div>
	    <div class="input-row">
	    	<label for="add-new-collection-radio">To a new collection</label>
      		<input id="add-new-collection-radio" type="radio" name="add-to-collection" />
      		<span id="add-collection-error" class="form-error right">* Required </span>
	    	<label class="input-title"> * Collection Title</label>
	    	<input type="text" id="add-new-collection-name" name="add-new-collection-name">
	    </div>
	    <ul class="l-grid clearfix grid-large-6">
	    	<li>
	    		<a id="add-collection-submit" href="#" class="primary-btn base-btn">SUBMIT</a>
	    	</li>
	    	<li>
	    		<a href="#" class="base-btn" class="close" data-dismiss="modal">CANCEL</a>
	    	</li>
		</ul>
      </div>
    </div>
  </div>
</div> 
  

{{HTML::script('js/views/details.js')}}  
<script>
    
function getTotalHeights() {
  var cast_div =  $("#cast_div").height();
  var runtime_div =  $("#runtime_div").height();
  var producers_div =  $("#producers_div").height();
  var genres_div =  $("#genres_div").height();
  var titles_nav =  $(".detail-titles-nav").height();
  
  return cast_div + runtime_div + producers_div + genres_div + titles_nav;
}    
function getSynopsisHeight() {
  var synopsis_div =  $("#about_div").height();
  return synopsis_div;
}

function getPartialsynopsis(numchars, title_id, callback_func ) {
   sendData = { "title_id" : title_id, "num_chars" : numchars };
   console.log(sendData);
   url = '/title/partialsynopsis/';
   $.get(url, sendData,  callback_func,  "json" );
}

$(document).ready(function() {
    
    var total_top_sections = getTotalHeights();

    var synopsis_height = getSynopsisHeight();

    if (( synopsis_height + total_top_sections ) > 602 ) 
    {
       // 20px of height = approximately 65 characters - 
       amt_of_height_over_600 = (synopsis_height + total_top_sections) - 350;
       // alert(amt_of_height_over_500);
       number_of_chars = 600;
//       number_of_20px_height_units = amt_of_height_over_600 / 8;
//       number_of_chars = number_of_20px_height_units * 112;
       getPartialsynopsis(number_of_chars, {{$data['title']['id']}}, function(data){
           $('#full_about').hide();
           $('#more_link').show();
           $('#partial_about').html(data['partial_synopsis'])
        } );
       
    //   $('#full_about').show();
    //   $('#about_div').height( synopsis_height - amt_of_height_over_600 );
   //    $('#more_link').hide();
       
    } 
    else 
    {
        $('#full_about').show()
        $('#more_link').hide();
    }
    
      //$('#partial_about').show();
      //$('#full_about').show()
    
  $('#more_link').click( function() { 
     if ($('#partial_about').is(":visible")) {
        $('#partial_about').hide();
        $('#full_about').show();
        $(this).html('<img src="/images/ar_up.png" style="vertical-align: text-bottom;"> Hide');
     } else {
        $('#partial_about').show();
        $('#full_about').hide();
        $(this).html('<img src="/images/ar_down.png" style="vertical-align: text-bottom;"> More');
               // $(this).html('<img src="/images/ar_down.png" style="vertical-align: text-bottom;"> View More');
    }
    });
    
  $(".confirm").confirm({
            text: "Are you sure you want to delete this title?",
            title: "Confirmation required",
            confirm: function(button) {
                theForm = document.createElement('form');
                    theForm.action = '/title/delete'; 
                    theForm.method = 'post';
                    newInput1 = document.createElement('input');
                    newInput1.type = 'hidden';
                    newInput1.name = 'title_id';
                    newInput1.value = '{{ $title['id'] }}';
                    theForm.appendChild(newInput1);
                    theForm.submit();
                },
                cancel: function(button) {
                    // do something
                },
                confirmButton: "YES",
                cancelButton: "NO",
                post: true
     
            });
});
 exports.title_operations.bindAddToCollHandler_Detailpage();
 exports.title_operations.bindFavoratingHandler_Detailpage();

var currentVideo = false;

function stopCurrentVideo()
{
    if (currentVideo !== false) {
        document.getElementById('video-' + currentVideo).pause();
        currentVideo = false;
    }
}
 
$('.overlay-video').click(function() {

    var idx = $(this).attr('data-video-thumb-idx');
    var media_id = $(this).attr('data-video-media-id');

    $('.dvd-video-mod').hide();
    $('#title-detail-video-'+idx).show();
    $('#title-detail-img').hide();

    stopCurrentVideo();
    document.getElementById('video-' + idx).play();
    currentVideo = idx;
      
    var title_id = $('#title_id').val();

                
                post_data = { "title_id" : title_id, "media_id" : media_id };
                
                $.post("/title/logvideoview", post_data, function( data ) {
                 
                   if (data['success']) {

                    } else {
                       $('.error-band').css("opacity","100");
                       $('.error-band').html("Logging this video view to reports has failed");
                       $('.error-band').delay(2000).animate({"opacity":"0"},1000);
                    }
                 })
                 .fail(function() {
                    $('.error_band').html("An unexpected error occurred");
                    $('.error-band').css("opacity","100");
                    $('.error-band').delay(10000).animate({"opacity":"0"},1000);
                }) 
 });
 
</script> 

<style>
.confirmation-modal.modal.fade.in .modal-footer .btn-default {
   margin-left: 0px;
   margin-top: 5px;
 }
.confirmation-modal.modal.fade.in .modal-header .close {
   display: none;
 }
</style>

{{ HTML::script('css/confirm/jquery.confirm.min.js') }}

</body>
</html>
