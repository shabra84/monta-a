<?php
class BWGViewThumbnails extends BWGViewSite {

  public function display($params = array(), $from_shortcode = 0, $bwg = 0) {
    $theme_row = $params['theme_row'];
    $image_rows = $params['image_rows'];
    $image_rows = $image_rows['images'];
    $inline_style = $this->inline_styles($bwg, $theme_row, $params);
    if (BWG()->options->use_inline_stiles_and_scripts) {
      wp_add_inline_style('bwg_frontend', $inline_style);
    }
    else {
      echo '<style>' . $inline_style . '</style>';
    }
    ob_start();
    ?>
    <div data-max-count="<?php echo $params['image_column_number']; ?>"
         data-thumbnail-width="<?php echo $params['thumb_width']; ?>"
         data-bwg="<?php echo $bwg; ?>"
         id="bwg_standart_thumbnails_<?php echo $bwg; ?>"
         class="bwg-container-<?php echo $bwg; ?> bwg-thumbnails bwg-container bwg-border-box">
      <?php
      foreach ($image_rows as $image_row) {
        $is_embed = preg_match('/EMBED/',$image_row->filetype) == 1 ? true : false;
        $is_embed_video = preg_match('/VIDEO/',$image_row->filetype) == 1 ? true : false;
        $class = '';
        $data_image_id = '';
        $href = '';
        $title = '<div class="bwg-title1"><div class="bwg-title2">' . ($image_row->alt ? $image_row->alt : '&nbsp;') . '</div></div>';
        $play_icon = '<div class="bwg-play-icon1"><i title="' . __('Play', BWG()->prefix) . '" class="fa fa-play bwg-title2 bwg-play-icon2"></i></div>';
        $ecommerce_icon = '<div class="bwg-ecommerce1"><div class="bwg-ecommerce2">';
        if ( $image_row->pricelist_id ) {
          $ecommerce_icon .= '<i title="' . __('Open', BWG()->prefix) . '" class="bwg_ctrl_btn bwg_open fa fa-share-square" ></i>&nbsp;';
          $ecommerce_icon .= '<i title="' . __('Ecommerce', BWG()->prefix) . '" class="bwg_ctrl_btn bwg_ecommerce fa fa-shopping-cart" ></i>';
        }
        else {
          $ecommerce_icon .= '&nbsp;';
        }
        $ecommerce_icon .= '</div></div>';
        if ( $params['thumb_click_action'] == 'open_lightbox' ) {
          $class = ' class="bwg_lightbox"';
          $data_image_id = ' data-image-id="' . $image_row->id . '"';
          if ( BWG()->options->enable_seo ) {
            $href = ' href="' . ($is_embed ? $image_row->thumb_url : BWG()->upload_url . $image_row->image_url) . '"';
          }
        }
        elseif ( $params['thumb_click_action'] == 'redirect_to_url' && $image_row->redirect_url ) {
          $href = ' href="' . $image_row->redirect_url . '" target="' .  ($params['thumb_link_target'] ? '_blank' : '')  . '"';
        }
        ?>
        <div class="bwg-item">
			<a <?php echo $class; ?><?php echo $data_image_id; ?><?php echo $href; ?>>
			<?php
			$effect_class_name = '';
			$effect_class_overlay_name = '';
			// init Zoom effect.
			if ( $theme_row->thumb_hover_effect == 'zoom' && $params['image_title'] == 'hover') {
				$effect_class_name = 'bwg-zoom-effect';
				$effect_class_overlay_name = 'bwg-zoom-effect-overlay';
			}
			?>
			<?php if ( $params['image_title'] == 'show' && $theme_row->thumb_title_pos == 'top' ) { echo $title; } ?>
			<div class="bwg-item0">
				<div class="bwg-item1 <?php echo $effect_class_name;?>">
					<div class="bwg-item2">
						<img class="bwg_standart_thumb_img_<?php echo $bwg; ?>"
						data-id="<?php echo $image_row->id; ?>"
						src="<?php echo ($is_embed ? "" : BWG()->upload_url) . $image_row->thumb_url; ?>"
						alt="<?php echo $image_row->alt; ?>" />
					</div>
					<div class="<?php echo $effect_class_overlay_name;?>">
					<?php if ( $params['image_title'] == 'hover' ) { echo $title; } ?>
                <?php if ( function_exists('BWGEC') && $params['ecommerce_icon'] == 'hover' && $image_row->pricelist_id ) { echo $ecommerce_icon; } ?>
                <?php if ( $is_embed_video && $params['play_icon'] ) { echo $play_icon; } ?>
					</div>
				</div>
			</div>
			<?php if ( function_exists('BWGEC') && $params['ecommerce_icon'] == 'show' ) { echo $ecommerce_icon; } ?>
			<?php if ( $params['image_title'] == 'show' && $theme_row->thumb_title_pos == 'bottom' ) { echo $title; } ?>
          </a>
		</div>
      <?php } ?>
    </div>
    <?php
    parent::container($params, $bwg, ob_get_clean());
    if ($from_shortcode) {
      return;
    }
    else {
      die();
    }
  }

  private function inline_styles($bwg, $theme_row, $params) {
    ob_start();
    $rgb_thumbs_bg_color = WDWLibrary::spider_hex2rgb($theme_row->thumbs_bg_color);
    ?>
    #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg-container-<?php echo $bwg; ?> {
      width: <?php echo ($params['image_column_number'] * $params['thumb_width']) + ($theme_row->container_margin ? $theme_row->thumb_margin : 0); ?>px;
      justify-content: <?php echo $theme_row->thumb_align; ?>;
      <?php
      if ( $theme_row->thumb_align == 'center' ) {
        ?>
        margin-left: auto;
        margin-right: auto;
        <?php
      }
      elseif ( $theme_row->thumb_align == 'left') {
        ?>
        margin-right: auto;
        <?php
      }
      else {
        ?>
        margin-left: auto;
        <?php
      }
      ?>
      background-color: rgba(<?php echo $rgb_thumbs_bg_color['red']; ?>, <?php echo $rgb_thumbs_bg_color['green']; ?>, <?php echo $rgb_thumbs_bg_color['blue']; ?>, <?php echo number_format($theme_row->thumb_bg_transparent / 100, 2, ".", ""); ?>);
      <?php
      if ( $theme_row->container_margin ) {
        ?>
      padding-left: <?php echo $theme_row->thumb_margin; ?>px;
      padding-top: <?php echo $theme_row->thumb_margin; ?>px;
      max-width: 100%;
        <?php
      }
      else {
        ?>
      margin-right: -<?php echo $theme_row->thumb_margin; ?>px;
      max-width: calc(100% + <?php echo $theme_row->thumb_margin; ?>px);
        <?php
      }
      ?>
    }
    #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg-container-<?php echo $bwg; ?> .bwg-item {
      justify-content: <?php echo $theme_row->thumb_title_pos == 'top'? 'flex-end' : 'flex-start'; ?>;
      max-width: <?php echo $params['thumb_width']; ?>px;
      <?php if ( !BWG()->options->resizable_thumbnails ) { ?>
      width: <?php echo $params['thumb_width']; ?>px !important;
      <?php } ?>
    }
    #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg-container-<?php echo $bwg; ?> .bwg-item > a {
       margin-right: <?php echo $theme_row->thumb_margin; ?>px;
       margin-bottom: <?php echo $theme_row->thumb_margin; ?>px;
    }
    #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg-container-<?php echo $bwg; ?> .bwg-item0 {
      padding: <?php echo $theme_row->thumb_padding; ?>px;
      background-color: #<?php echo $theme_row->thumb_bg_color; ?>;
      border: <?php echo $theme_row->thumb_border_width; ?>px <?php echo $theme_row->thumb_border_style; ?> #<?php echo $theme_row->thumb_border_color; ?>;
      opacity: <?php echo number_format($theme_row->thumb_transparent / 100, 2, ".", ""); ?>;
      filter: Alpha(opacity=<?php echo $theme_row->thumb_transparent; ?>);
      border-radius: <?php echo $theme_row->thumb_border_radius; ?>;
      box-shadow: <?php echo $theme_row->thumb_box_shadow; ?>;
    }
    #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg-container-<?php echo $bwg; ?> .bwg-item1 img {
      max-height: none;
      max-width: none;
      padding: 0 !important;
    }
    <?php if ( $theme_row->thumb_hover_effect == 'zoom' ) { ?>
     @media only screen and (min-width: 480px) {
		#bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg-container-<?php echo $bwg; ?> .bwg-item1 img {
			<?php echo ($theme_row->thumb_transition) ? '-webkit-transition: all .3s; transition: all .3s;' : ''; ?>
		}
		#bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg-container-<?php echo $bwg; ?> .bwg-item1 img:hover {
			-ms-transform: scale(<?php echo $theme_row->thumb_hover_effect_value; ?>);
			-webkit-transform: scale(<?php echo $theme_row->thumb_hover_effect_value; ?>);
			transform: scale(<?php echo $theme_row->thumb_hover_effect_value; ?>);
		}
		<?php if ( $params['image_title'] == 'hover' ) { ?>
		.bwg-zoom-effect .bwg-zoom-effect-overlay {
			<?php $thumb_bg_color = WDWLibrary::spider_hex2rgb( $theme_row->thumb_bg_color ); ?>
			background-color:rgba(<?php echo $thumb_bg_color['red'] .','. $thumb_bg_color['green'] . ',' . $thumb_bg_color['blue'] . ', 0.3'; ?>);
		}
		.bwg-zoom-effect:hover img {
			-ms-transform: scale(<?php echo $theme_row->thumb_hover_effect_value; ?>);
			-webkit-transform: scale(<?php echo $theme_row->thumb_hover_effect_value; ?>);
			transform: scale(<?php echo $theme_row->thumb_hover_effect_value; ?>);
		}
		<?php } ?>
      }
	<?php
    }
    else {
    ?>
    @media only screen and (min-width: 480px) {
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg-container-<?php echo $bwg; ?> .bwg-item0 {
        <?php echo ($theme_row->thumb_transition) ? 'transition: all 0.3s ease 0s;-webkit-transition: all 0.3s ease 0s;' : ''; ?>
      }
      #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg-container-<?php echo $bwg; ?> .bwg-item0:hover {
        -ms-transform: <?php echo $theme_row->thumb_hover_effect; ?>(<?php echo $theme_row->thumb_hover_effect_value; ?>);
        -webkit-transform: <?php echo $theme_row->thumb_hover_effect; ?>(<?php echo $theme_row->thumb_hover_effect_value; ?>);
        transform: <?php echo $theme_row->thumb_hover_effect; ?>(<?php echo $theme_row->thumb_hover_effect_value; ?>);
      }
    }
      <?php
    }
    ?>
    #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg-container-<?php echo $bwg; ?> .bwg-item1 {
      padding-top: <?php echo $params['thumb_height'] / $params['thumb_width'] * 100; ?>%;
    }
    <?php
	/* Show image title on hover.*/
    if ( $params['image_title'] == 'hover' ) { ?>
    #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg-container-<?php echo $bwg; ?> .bwg-title1 {
      position: absolute;
      top: 0;
      z-index: 100;
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-content: center;
      flex-direction: column;
      filter: Alpha(opacity=0);
      opacity: 0;
    }
	<?php } ?>
    #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg-container-<?php echo $bwg; ?> .bwg-title2,
    #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg-container-<?php echo $bwg; ?> .bwg-ecommerce2 {
		color: #<?php echo ( $params['image_title'] == 'hover') ? (isset($theme_row->thumb_title_font_color_hover) ? $theme_row->thumb_title_font_color_hover : $theme_row->thumb_title_font_color) : $theme_row->thumb_title_font_color; ?>;
		font-family: <?php echo $theme_row->thumb_title_font_style; ?>;
		font-size: <?php echo $theme_row->thumb_title_font_size; ?>px;
		font-weight: <?php echo $theme_row->thumb_title_font_weight; ?>;
		padding: <?php echo $theme_row->thumb_title_margin; ?>;
		text-shadow: <?php echo $theme_row->thumb_title_shadow; ?>;
		max-height:100%;
    }
    #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg-container-<?php echo $bwg; ?> .bwg-play-icon2 {
      font-size: <?php echo 2 * $theme_row->thumb_title_font_size; ?>px;
    }
    #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg-container-<?php echo $bwg; ?> .bwg-ecommerce2 {
      font-size: <?php echo 1.2 * $theme_row->thumb_title_font_size; ?>px;
    }
    <?php
    if ( function_exists('BWGEC') && $params['ecommerce_icon'] == 'hover' ) { /* Show eCommerce icon on hover.*/
      ?>
    #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> .bwg-container-<?php echo $bwg; ?> .bwg-ecommerce1 {
      display: flex;
      height: 100%;
      left: -3000px;
      opacity: 0;
      filter: Alpha(opacity=0);
      position: absolute;
      top: 0;
      width: 100%;
      z-index: 100;
      justify-content: center;
      align-content: center;
      flex-direction: column;
      text-align: center;
    }
      <?php
    }
    ?>
    #bwg_container1_<?php echo $bwg; ?> #bwg_container2_<?php echo $bwg; ?> #spider_popup_overlay_<?php echo $bwg; ?> {
      background-color: #<?php echo $theme_row->lightbox_overlay_bg_color; ?>;
      opacity: <?php echo number_format($theme_row->lightbox_overlay_bg_transparent / 100, 2, ".", ""); ?>;
      filter: Alpha(opacity=<?php echo $theme_row->lightbox_overlay_bg_transparent; ?>);
    }
    <?php
    return ob_get_clean();
  }
}
