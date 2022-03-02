<?php

namespace FluentForm\App\Services\FormBuilder\Components;

use FluentForm\Framework\Helpers\ArrayHelper;

class CustomHtml extends BaseComponent
{
	/**
	 * Compile and echo the html element
	 * @param  array $data [element data]
	 * @param  stdClass $form [Form Object]
	 * @return viod
	 */
	public function compile($data, $form)
	{
		$elementName = $data['element'];
        $data = apply_filters('fluentform_rendering_field_data_'.$elementName, $data, $form);
		
        $hasConditions = $this->hasConditions($data) ? 'has-conditions ' : '';
		$cls = trim($this->getDefaultContainerClass() .' ff-'.$elementName.' '.$hasConditions);
		if($containerClass = ArrayHelper::get($data, 'settings.container_class')) {
			$cls .= ' '.$containerClass;
        }
		$atts = $this->buildAttributes(
			ArrayHelper::except($data['attributes'], 'name')
		);

		if ($data['settings']['show_as_reveal_text']) {
			$length = $data['settings']['show_count_length'] ? $data['settings']['show_count_length'] : 50 ;
			
			$showText = substr(strip_tags($data['settings']['html_codes']), 0, $length);
			$showText .=  '...';
			
			$elementId = $this->makeElementId($data, $form);

			$readMoreButton = "<p class='read-more ff_read_more_btn' type='button' id='". $elementId.'_read_more_button' ."'><a href='#'>".$data['settings']['readmore_button_text']."<span>&rarr;</span></a></p>";
			$allText = $data['settings']['html_codes'];

			$readLessButton = "<p class='ff_read_less_btn'> <a href='#'><span>&larr;</span>" . $data['settings']['readless_button_text']."</a></p>";

			$innerHtml = "<div class='ff_truncated_text'>{$showText} {$readMoreButton}</div> <div class='ff_full_text ff_hide_text'>{$allText} {$readLessButton}</div>";
		} else {
			$innerHtml = $data['settings']['html_codes'];
		}
		$html = "<div class='{$cls}' {$atts}>{$innerHtml}</div>";
		$html = apply_filters('fluentform_rendering_field_html_'.$elementName, $html, $data, $form);
        echo $html;
		if ($data['settings']['show_as_reveal_text']) {
			?>
				<script>
					(function($){
						$('.ff_read_more_btn').on('click', function (event) {
							event.preventDefault();

							var $parent = $(this).closest('.ff-el-group');

							console.log('adre');
							
							$parent.find('.ff_truncated_text').hide();
							$parent.find('.ff_full_text').show();
						})

						$('.ff_read_less_btn').on('click', function (event) {
							event.preventDefault();

							var $parent = $(this).closest('.ff-el-group');
							
							$parent.find('.ff_truncated_text').show();
							$parent.find('.ff_full_text').hide();

						})
					})(jQuery)
				</script>
			<?php
		}
    }
}
