<?php
/**
 * @package Xpert Tweets
 * @version 1.2
 * @author ThemeXpert http://www.themexpert.com
 * @copyright Copyright (C) 2010 - 2012 ThemeXpert
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined('_JEXEC') or die;
$i = 1;
$total = count($list);
$width = '';
if($params->get('layouts') == 'horizontal')
{
    $val = 100/$total;
    $width = "style=\"width:$val%\"";
}
?>

<div id="xt-wrap" class="<?php echo $moduleclass_sfx; ?> xt-<?php echo $params->get('layouts')?> xt-<?php echo $params->get('style')?>">
    <div class="xt-inner-wrap">
        <?php if(isset($profile)) :?>
        <div class="xt-profile">
            <div class="xt-profile-header clearfix">
                <img src="<?php echo $profile['image_url']?>" alt="<?php echo $profile['name']?>">
                <h4><?php echo $profile['name']?></h4>
                <p><?php echo $profile['description']?></p>
            </div>
            <div class="xt-profile-info">
                <p>
                    <span>web: </span> <a href="<?php echo $profile['url']?>"><?php echo $profile['url']?></a>
                </p>
                <p>
                    <span>followers: </span> <?php echo $profile['followers']?>
                </p>
                <p>
                    <span>following: </span> <?php echo $profile['following']?>
                </p>

            </div>
        </div>
        <?php endif; ?>

        <ul class="xt-list clearfix">
        <?php foreach ($list as $item) :  ?>
        	<?php
        		if($i == 1) $class = ' xt-first';
        		elseif($i == $total) $class=' xt-last';
        		else $class= '';
        	?>
        	<li class="<?php echo ($i %2) ? 'odd' : 'even' ; ?><?php echo $class;?>" <?php echo $width ?> >
        		<div class="xt-inner-pad">
                    <?php if($params->get('profile_image',1)): ?>
                    <div class="xt-avatar">
                        <a href="http://twitter.com/<?php echo $item->user; ?>" target="_blank">
                            <img src="<?php echo $item->profile_image; ?>" alt="<?php echo $item->user; ?>">
                        </a>
                    </div>
                    <?php endif;?>

                    <div class="xt-tweet-wrap">
                        <?php if($params->get('time',1)): ?>
                            <span class="xt-time"><?php echo $item->time; ?></span>
                        <?php endif; ?>

                        <?php if($params->get('source',0)): ?>
                            <div class="xt-source"><?php echo html_entity_decode($item->source); ?></div>
                        <?php endif;?>

                        <p class="xt-tweet">
                            <?php echo $item->text; ?>
                        </p>
                    </div>
                </div>
        	</li>
        	<?php $i++; ?>
        <?php endforeach; ?>
        </ul>

        <?php if( $params->get('show_tweet') == 'user' AND $params->get('follow') ):?>
            <a class="follow_us" href="http://twitter.com/<?php echo $list[0]->user; ?>" target="_blank">
                <?php echo $params->get('follow_text', 'Follow us on twitter'); ?>
            </a>
        <?php endif;?>
    </div>
</div>
