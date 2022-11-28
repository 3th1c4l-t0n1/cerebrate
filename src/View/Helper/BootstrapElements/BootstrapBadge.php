<?php

namespace App\View\Helper\BootstrapElements;

use App\View\Helper\BootstrapGeneric;


/**
 * Creates a Bootstrap badge
 * 
 * # Options:
 * - text: The text content of the badge
 * - html: The HTML content of the badge
 * - variant: The Bootstrap variant of the badge
 * - pill: Should the badge have a Bootstrap pill style
 * - title: The title of the badge
 * - class: Additional class to add to the button
 * 
 * # Usage:
 *  echo $this->Bootstrap->badge([
 *    'text' => 'text',
 *    'variant' => 'success',
 *    'pill' => false,
 * ]);
 */
class BootstrapBadge extends BootstrapGeneric
{
    private $defaultOptions = [
        'text' => '',
        'html' => null,
        'variant' => 'primary',
        'pill' => false,
        'title' => '',
        'class' => [],
    ];

    function __construct(array $options)
    {
        $this->allowedOptionValues = [
            'variant' => BootstrapGeneric::$variants,
        ];
        $this->processOptions($options);
    }

    private function processOptions(array $options): void
    {
        $this->options = array_merge($this->defaultOptions, $options);
        $this->options['class'] = $this->convertToArrayIfNeeded($this->options['class']);
        $this->checkOptionValidity();
    }

    public function badge(): string
    {
        return $this->genBadge();
    }

    private function genBadge(): string
    {
        $html = $this->node('span', [
            'class' => array_merge($this->options['class'], [
                'ms-1',
                'badge',
                self::getBGAndTextClassForVariant($this->options['variant']),
                $this->options['pill'] ? 'rounded-pill' : '',
            ]),
            'title' => $this->options['title']
        ], $this->options['html'] ?? h($this->options['text']));
        return $html;
    }
}
