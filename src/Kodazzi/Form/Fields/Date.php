<?php
/**
 * This file is part of the Kodazzi Framework.
 *
 * (c) Jorge Gaitan <info@kodazzi.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Kodazzi\Form\Fields;

Class Date extends \Kodazzi\Form\Field
{
    protected $format_date = 'Y-m-d';

	public function valid()
	{
		$default = '^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$';

		if($this->pattern)
		{
			$default = $this->pattern;
		}

		if (preg_match('/'.$default.'/', $this->value))
		{
			return true;
		}

		return false;
	}

	public function renderField()
	{
		if(!$this->is_display)
			return '';

        $format = ($this->format) ? $this->format : $this->name_form . '[' . $this->name . ']';
        $id = ($this->id) ? $this->id : $this->name_form . '_' . $this->name;

        $value = ($this->value) ? \Kodazzi\Tools\Date::format($this->value, $this->format_date) : '';

		return \Kodazzi\Helper\FormHtml::input($format, $value, $this->max_length, array(
					'id' => $id,
					'class' => $this->getClassCss(),
					'disabled' => $this->isDisabled(),
					'readonly' => $this->isReadonly(),
                    'placeholder' => $this->getPlaceholder()
				), $this->other_attributes );
	}

    public function setFormatDate( $format_date )
    {
        $this->format_date = $format_date;

        return $this;
    }
}