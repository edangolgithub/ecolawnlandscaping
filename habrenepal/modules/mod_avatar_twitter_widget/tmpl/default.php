<?php 
/**
 * @version		$Id: default.php 5 2012-04-06 20:10:35Z mozart $
 * @copyright	JoomAvatar.com
 * @author		Tran Nam Chung
 * @mail		chungtn2910@gmail.com
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$document = JFactory::getDocument();
$document->addScript('http://widgets.twimg.com/j/2/widget.js');
echo "<div style='text-align: center;'>";
for($n = 0; $n < sizeof($display); $n++)
{
	switch ($display[$n]) 
	{
		case 'tweetbtn':?>
			<a href="<?php switch ($tweetBtnType) 
			{
				case 'twitter-hashtag-button':
					echo "https://twitter.com/intent/tweet?button_hashtag=$tweetHashtag&text=$tweetHashtagTxt";
					break;
				case 'twitter-mention-button':
					echo "https://twitter.com/intent/tweet?screen_name=$tweetMentionNamge";
					break;
				case 'twitter-share-button':
					echo "https://twitter.com/share";
					break;
			}?>" class="<?php echo $tweetBtnType?>" data-hashtags="<?php echo $tweetHashtag;  ?>" data-text="<?php echo $tweetHashtagTxt; ?>" data-lang="en" data-related="<?php echo $tweetRelated?>" data-size="<?php echo $tweetBtnSize?>" data-count="<?php echo $tweetCount?>" data-url="<?php echo $tweetUrl?>" data-via="<?php echo $tweetVia?>">Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			<?php break;
		case 'followbtn': ?>
			<a href="https://twitter.com/<?php echo $followBtn?>" class="twitter-follow-button" data-show-count="<?php echo $followCount?>" data-show-screen-name="<?php echo $followScreenName?>" data-width="<?php echo $followWidth?>" data-align="<?php echo $followAlign?>" data-size="<?php echo $followBtnSize?>" data-lang="en">Folloư</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		<?php	break;
		case 'widget':?>
			<a class="twitter-timeline" data-widget-id="<?php echo $widgetId;?>">Tweets Widget</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

		<?php
			break;
	}?>
<?php }?>
<!--<div class="avatar-copyright" style="width:100%;margin: 5px;text-align: center;">
© JoomAvatar.com
	<a target="_blank" href="http://joomavatar.com" title="Joomla Template & Extension">Joomla Extension</a>-
	<a target="_blank" href="http://joomavatar.com" title="Joomla Template & Extension">Joomla Template</a>
</div>-->
</div>