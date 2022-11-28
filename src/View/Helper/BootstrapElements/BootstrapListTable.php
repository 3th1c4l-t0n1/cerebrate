<?php

namespace App\View\Helper\BootstrapElements;

use Cake\Utility\Hash;

use App\View\Helper\BootstrapGeneric;

/**
 * Creates a list looking like a table from 1-dimensional data $item.
 * Perfect to display the Key-Values of an object.
 * 
 * # Options for table
 *  - striped, bordered, borderless, hover, small: Default bootstrap behavior
 *  - variant: Variant to apply on the entire table
 *  - tableClass: A list of class to add on the table container
 *  - bodyClass: A list of class to add on the tbody container
 *  - id: The ID to use for the table
 *  - caption: Optional table caption
 *  - elementsRootPath: Root path to use when item are relying on cakephp's element. See options for fields
 * 
 * # Items
 *  - They have the content that's used to generate the table. Typically and array<array> or array<entity>
 * 
 * # Options for fields
 *  - key: The name of the field to be displayed as a label
 *  - keyHtml: The HTML of the field to be displayed as a label
 *  - path: The path to be fed to Hash::get() in order to get the value from the $item
 *  - raw: The raw value to be displayed. Disable the `path` option
 *  - rawNoEscaping: If the raw value should not be escaped. False by default
 *  - type: The type of element to use combined with $elementsRootPath from the table's option
 *  - formatter: A callback function to format the value
 *  - cellVariant: The bootstrap variant to be applied on the cell
 *  - rowVariant: The bootstrap variant to be applied on the row
 *  - notice_$variant: A text with the passed variant to be append at the end
 * 
 * # Usage:
 *      $this->Bootstrap->listTable(
 *          [
 *              'hover' => false,
 *              'variant' => 'success',
 *          ],
 *          [
 *              'item' => [
 *                  'key1' => 'value1',
 *                  'key2' => true,
 *                  'key3' => 'value3',
 *              ],
 *              'fields' => [
 *                  [
 *                      'key' => 'Label 1',
 *                      'path' => 'key1',
 *                      'notice_warning' => '::warning::',
 *                      'notice_danger' => '::danger::',
 *                      'rowVariant' => 'danger',
 *                      'cellVariant' => 'success',
 *                  ],
 *                  [
 *                      'key' => 'Label 2',
 *                      'path' => 'key2',
 *                      'type' => 'boolean',
 *                  ],
 *                  [
 *                      'key' => 'Label 3',
 *                      'raw' => '<b>raw_value</b>',
 *                      'rawNoEscaping' => true,
 *                  ],
 *                  [
 *                      'key' => 'Label 4',
 *                      'path' => 'key3',
 *                      'formatter' => function ($value) {
 *                          return '<i>' . $value . '</i>';
 *                      },
 *                  ],
 *              ],
 *              'caption' => 'This is a caption'
 *          ]
 *      );
 */
class BootstrapListTable extends BootstrapGeneric
{
    private $defaultOptions = [
        'striped' => true,
        'bordered' => false,
        'borderless' => false,
        'hover' => true,
        'small' => false,
        'variant' => '',
        'tableClass' => [],
        'bodyClass' => [],
        'id' => '',
        'caption' => '',
        'elementsRootPath' => '/genericElements/SingleViews/Fields/',
    ];

    function __construct($options, $data, $btHelper)
    {
        $this->allowedOptionValues = [
            'variant' => array_merge(BootstrapGeneric::$variants, [''])
        ];
        $this->processOptions($options);
        $this->fields = $data['fields'];
        $this->item = $data['item'];
        $this->caption = !empty($data['caption']) ? $data['caption'] : '';
        $this->btHelper = $btHelper;
    }

    private function processOptions($options)
    {
        $this->options = array_merge($this->defaultOptions, $options);
        $this->options['tableClass'] = $this->convertToArrayIfNeeded($this->options['tableClass']);
        $this->options['bodyClass'] = $this->convertToArrayIfNeeded($this->options['bodyClass']);
        $this->checkOptionValidity();
    }

    public function table()
    {
        return $this->genTable();
    }

    private function genTable()
    {
        $html = $this->nodeOpen('table', [
            'class' => [
                'table',
                "table-{$this->options['variant']}",
                $this->options['striped'] ? 'table-striped' : '',
                $this->options['bordered'] ? 'table-bordered' : '',
                $this->options['borderless'] ? 'table-borderless' : '',
                $this->options['hover'] ? 'table-hover' : '',
                $this->options['small'] ? 'table-sm' : '',
                implode(' ', $this->options['tableClass']),
                !empty($this->options['variant']) ? "table-{$this->options['variant']}" : '',
            ],
            'id' => $this->options['id'] ?? ''
        ]);

        $html .= $this->genCaption();
        $html .= $this->genBody();

        $html .= $this->nodeClose('table');
        return $html;
    }

    private function genBody()
    {
        $body =  $this->nodeOpen('tbody', [
            'class' => $this->options['bodyClass'],
        ]);
        foreach ($this->fields as $i => $field) {
            $body .= $this->genRow($field);
        }
        $body .= $this->nodeClose('tbody');
        return $body;
    }

    private function genRow($field)
    {
        $rowValue = $this->genCell($field);
        $rowKey = $this->node('th', [
            'class' => [
                'col-4 col-sm-2'
            ],
            'scope' => 'row'
        ], $field['keyHtml'] ?? h($field['key']));
        $row = $this->node('tr', [
            'class' => [
                'd-flex',
                !empty($field['rowVariant']) ? "table-{$field['rowVariant']}" : ''
            ]
        ], [$rowKey, $rowValue]);
        return $row;
    }

    private function genCell($field = [])
    {
        if (isset($field['raw'])) {
            $cellContent = !empty($field['rawNoEscaping']) ? $field['raw'] : h($field['raw']);
        } else if (isset($field['formatter'])) {
            $cellContent = $field['formatter']($this->getValueFromObject($field), $this->item);
        } else if (isset($field['type'])) {
            $cellContent = $this->btHelper->getView()->element($this->getElementPath($field['type']), [
                'data' => $this->item,
                'field' => $field
            ]);
        } else {
            $cellContent = h($this->getValueFromObject($field));
        }
        foreach (BootstrapGeneric::$variants as $variant) {
            if (!empty($field["notice_$variant"])) {
                $cellContent .= sprintf(' <span class="text-%s">%s</span>', $variant, $field["notice_$variant"]);
            }
        }
        return $this->node('td', [
            'class' => [
                'col-8 col-sm-10',
                !empty($field['cellVariant']) ? "bg-{$field['cellVariant']}" : ''
            ]
        ], $cellContent);
    }

    private function getValueFromObject($field)
    {
        $key = is_array($field) ? $field['path'] : $field;
        $cellValue = Hash::get($this->item, $key);
        return $cellValue;
    }

    private function getElementPath($type)
    {
        return sprintf(
            '%s%sField',
            $this->options['elementsRootPath'] ?? '',
            $type
        );
    }

    private function genCaption()
    {
        return !empty($this->caption) ? $this->node('caption', [], h($this->caption)) : '';
    }
}