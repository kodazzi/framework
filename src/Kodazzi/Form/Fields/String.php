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

Class String extends \Kodazzi\Form\Field
{
	protected $min_length = 1;

	/* 
	 * Solo permite cadenas con letras, numeros y espacios
	 * Util para validar nombres, segundo nombre, apellidos de personas 
	 */
	public function valid()
	{
		$default = '^[\w\s\/\-\_\&\;\#\.\,\?\¿\!\¡\(\)\{\}]+$';

        // Reemplaza todas las vocales acentuadas
        $value = \Kodazzi\Tools\StringProcessor::replaceVowels( $this->value );

		if( $this->pattern )
		{
			$default = $this->pattern;
		}

		if ( preg_match('/'.$default.'/', $value ) )
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

		return \Kodazzi\Helper\FormHtml::input($format, $this->value, $this->max_length, array(
					'id' => $id,
					'class' => $this->getClassCss(),
					'disabled' => $this->isDisabled(),
					'readonly' => $this->isReadonly(),
                    'placeholder' => $this->getPlaceholder()
				),
				$this->other_attributes
		);
	}

}