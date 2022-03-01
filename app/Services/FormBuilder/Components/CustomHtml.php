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
			$readMoreButton = "<button type='button' id='". $elementId.'_read_more_button' ."'>".$data['settings']['readmore_button_text']."</button>";
			$readLessButton = "<button type='button' id='". $elementId.'_read_less_button' . "'>" . $data['settings']['readless_button_text']."</button>";
			$innerHtml = "<p id='" . $elementId.'_text' . "'>" . $showText . $readMoreButton ."</p>";
			$allText = $data['settings']['html_codes'];
		
		}else{
			$innerHtml = $data['settings']['html_codes'];
		}
		$html = "<div class='{$cls}' {$atts}>{$innerHtml}</div>";
		$html = apply_filters('fluentform_rendering_field_html_'.$elementName, $html, $data, $form);
        echo $html;
    }
}
