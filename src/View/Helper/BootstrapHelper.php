<?php

/**
 * Bootstrap Helper class to quicly create Bootstrap components
 * 
 * # Usage:
 *    $this->Bootstrap->{$componentName}($options);
 */

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Utility\Text;
use InvalidArgumentException;

use \App\View\Helper\BootstrapElements\BootstrapSwitch;
use \App\View\Helper\BootstrapElements\BootstrapTabs;
use \App\View\Helper\BootstrapElements\BootstrapAlert;
use \App\View\Helper\BootstrapElements\BootstrapAccordion;
use \App\View\Helper\BootstrapElements\BootstrapBadge;
use \App\View\Helper\BootstrapElements\BootstrapButton;
use \App\View\Helper\BootstrapElements\BootstrapCard;
use \App\View\Helper\BootstrapElements\BootstrapCollapse;
use \App\View\Helper\BootstrapElements\BootstrapDropdownMenu;
use \App\View\Helper\BootstrapElements\BootstrapIcon;
use \App\View\Helper\BootstrapElements\BootstrapListGroup;
use \App\View\Helper\BootstrapElements\BootstrapListTable;
use \App\View\Helper\BootstrapElements\BootstrapModal;
use \App\View\Helper\BootstrapElements\BootstrapNotificationBubble;
use \App\View\Helper\BootstrapElements\BootstrapProgress;
use \App\View\Helper\BootstrapElements\BootstrapProgressTimeline;
use \App\View\Helper\BootstrapElements\BootstrapTable;
use \App\View\Helper\BootstrapElements\BootstrapToast;


const COMPACT_ATTRIBUTES = [
    'checked' => true,
    'default' => true,
    'disabled' => true,
    'enabled' => true,
    'hidden' => true,
    'multiple' => true,
    'novalidate' => true,
    'readonly' => true,
    'required' => true,
    'selected' => true,
    'visible' => true,
];

class BootstrapHelper extends Helper
{
    public $helpers = ['FontAwesome'];

    /**
     * Creates a Bootstrap tabs from the given options
     *
     * @param array $options See BootstrapElements\BootstrapTabs
     * @return string
     */
    public function tabs(array $options): string
    {
        $bsTabs = new BootstrapTabs($options);
        return $bsTabs->tabs();
    }

    /**
     * Creates a Bootstrap tabs from the given options
     *
     * @param array $options See BootstrapElements\BootstrapTabs
     * @return string
     */
    public function alert(array $options): string
    {
        $bsAlert = new BootstrapAlert($options);
        return $bsAlert->alert();
    }

    /**
     * Creates a Bootstrap tabs from the given options
     *
     * @param array $options See BootstrapElements\BootstrapTabs
     * @param array $data See BootstrapElements\BootstrapTabs
     * @return string
     */
    public function table(array $options, array $data = []): string
    {
        $bsTable = new BootstrapTable($options, $data, $this);
        return $bsTable->table();
    }

    /**
     * Creates a Bootstrap tabs from the given options
     *
     * @param array $options See BootstrapElements\BootstrapTabs
     * @param array $data See BootstrapElements\BootstrapTabs
     * @return string
     */
    public function listTable(array $options, array $data = []): string
    {
        $bsListTable = new BootstrapListTable($options, $data, $this);
        return $bsListTable->table();
    }

    /**
     * Creates a Bootstrap tabs from the given options
     *
     * @param array $options See BootstrapElements\BootstrapTabs
     * @return string
     */
    public function button(array $options): string
    {
        $bsButton = new BootstrapButton($options);
        return $bsButton->button();
    }

    /**
     * Creates a Bootstrap tabs from the given options
     *
     * @param string $icon See BootstrapElements\BootstrapTabs
     * @param array $options See BootstrapElements\BootstrapTabs
     * @return string
     */
    public function icon(string $icon, array $options = []): string
    {
        $bsIcon = new BootstrapIcon($icon, $options);
        return $bsIcon->icon();
    }

    /**
     * Creates a Bootstrap tabs from the given options
     *
     * @param array $options See BootstrapElements\BootstrapTabs
     * @return string
     */
    public function badge(array $options): string
    {
        $bsBadge = new BootstrapBadge($options);
        return $bsBadge->badge();
    }

    /**
     * Creates a Bootstrap tabs from the given options
     *
     * @param array $options See BootstrapElements\BootstrapTabs
     * @return string
     */
    public function modal(array $options): string
    {
        $bsModal = new BootstrapModal($options);
        return $bsModal->modal();
    }

    /**
     * Creates a Bootstrap tabs from the given options
     *
     * @param array $options See BootstrapElements\BootstrapTabs
     * @return string
     */
    public function card(array $options): string
    {
        $bsCard = new BootstrapCard($options);
        return $bsCard->card();
    }

    /**
     * Creates a Bootstrap tabs from the given options
     *
     * @param array $options See BootstrapElements\BootstrapTabs
     * @return string
     */
    public function progress(array $options): string
    {
        $bsProgress = new BootstrapProgress($options);
        return $bsProgress->progress();
    }

    /**
     * Creates a Bootstrap tabs from the given options
     *
     * @param array $options See BootstrapElements\BootstrapTabs
     * @param string $content See BootstrapElements\BootstrapTabs
     * @return string
     */
    public function collapse(array $options, string $content): string
    {
        $bsCollapse = new BootstrapCollapse($options, $content, $this);
        return $bsCollapse->collapse();
    }

    /**
     * Creates a Bootstrap tabs from the given options
     *
     * @param array $options See BootstrapElements\BootstrapTabs
     * @param array $content See BootstrapElements\BootstrapTabs
     * @return string
     */
    public function accordion(array $options, array $content): string
    {
        $bsAccordion = new BootstrapAccordion($options, $content, $this);
        return $bsAccordion->accordion();
    }

    /**
     * Creates a Bootstrap tabs from the given options
     *
     * @param array $options See BootstrapElements\BootstrapTabs
     * @return string
     */
    public function progressTimeline(array $options): string
    {
        $bsProgressTimeline = new BootstrapProgressTimeline($options, $this);
        return $bsProgressTimeline->progressTimeline();
    }

    /**
     * Creates a Bootstrap tabs from the given options
     *
     * @param array $data See BootstrapElements\BootstrapTabs
     * @param array $options See BootstrapElements\BootstrapTabs
     * @return string
     */
    public function listGroup(array $data, array $options = []): string
    {
        $bsListGroup = new BootstrapListGroup($data, $options, $this);
        return $bsListGroup->listGroup();
    }

    /**
     * Creates a Bootstrap tabs from the given options
     *
     * @param array $options See BootstrapElements\BootstrapTabs
     * @return string
     */
    public function switch(array $options): string
    {
        $bsSwitch = new BootstrapSwitch($options, $this);
        return $bsSwitch->switch();
    }

    /**
     * Creates a Bootstrap tabs from the given options
     *
     * @param array $options See BootstrapElements\BootstrapTabs
     * @return string
     */
    public function notificationBubble(array $options): string
    {
        $bsNotificationBubble = new BootstrapNotificationBubble($options, $this);
        return $bsNotificationBubble->notificationBubble();
    }

    /**
     * Creates a Bootstrap tabs from the given options
     *
     * @param array $options See BootstrapElements\BootstrapTabs
     * @return string
     */
    public function dropdownMenu(array $options): string
    {
        $bsDropdownMenu = new BootstrapDropdownMenu($options, $this);
        return $bsDropdownMenu->dropdownMenu();
    }

    /**
     * Creates a Bootstrap toast from the given options
     *
     * @param array $options
     * @return string
     */
    public function toast(array $options): string
    {
        $bsToast = new BootstrapToast($options, $this);
        return $bsToast->toast();
    }

    /**
     * Creates a HTML node
     *
     * @param string $tag The tag of the node. Example: `div`, `span`, ...
     * @param array $attrs Optional HTML attributes to be added on the node
     * @param string $content Optional innerHTML of the node
     * @param array $options Optional options to build the node. See BootstrapGeneric\node
     * @return string
     */
    public function node(string $tag, array $attrs = [], string $content = '', array $options = []): string
    {
        return BootstrapGeneric::node($tag, $attrs, $content, $options);
    }

    /**
     * Render the provided template with the given data
     *
     * @param string $template The template to render. See BootstrapGeneric\render
     * @param array $data The data to be used during the template building
     * @param array $options Optional options to build the template
     * @return string
     */
    public function render(string $template, array $data = [], array $options = []): string
    {
        return BootstrapGeneric::render($template, $data, $options);
    }
}


class BootstrapGeneric
{
    public static $variants = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark', 'white', 'transparent'];
    public static $textClassByVariants = [
        'primary' => 'text-light',
        'secondary' => 'text-light',
        'success' => 'text-light',
        'danger' => 'text-light',
        'warning' => 'text-dark',
        'info' => 'text-light',
        'light' => 'text-dark',
        'dark' => 'text-light',
        'white' => 'text-dark',
        'transparent' => 'text-dark'
    ];
    protected $allowedOptionValues = [];
    protected $options = [];

    protected function checkOptionValidity()
    {
        foreach ($this->allowedOptionValues as $option => $values) {
            if (!isset($this->options[$option])) {
                throw new InvalidArgumentException(__('Option `{0}` should have a value', $option));
            }
            if (!in_array($this->options[$option], $values)) {
                throw new InvalidArgumentException(__('Option `{0}` is not a valid option for `{1}`. Accepted values: {2}', json_encode($this->options[$option]), $option, json_encode($values)));
            }
        }
    }

    /**
     * Replaces {{placeholders}} inside a $template with the given $data
     * 
     * Example:
     * ```
     * render('{{name}} is {{age}} years old.', ['name' => 'Bob', 'age' => '65']);
     * ```
     * Returns: Bob is 65 years old.
     *
     * @param string $template The template containing the placeholders
     * @param array $data A K-V array where keys are placeholder name to be replaced by their value
     * @param array<string, mixed> $options Array of options passed to the Text::insert function
     * @return string
     */
    public static function render(string $template, array $data, array $options=[]): string
    {
        $defaults = [
            'before' => '{{', 'after' => '}}', 'escape' => '\\', 'format' => null, 'clean' => false,
        ];
        $options += $defaults;
        return Text::insert(
            $template,
            $data,
            $options
        );
    }

    /**
     * Creates an HTML node
     *
     * # Options
     *
     * - `escape` Set to false to disable escaping of attribute value.
     * 
     * @param string $tag The tag of the node. Example: 'div', 'span'
     * @param array $attrs Attributes to be added to the node
     * @param string|array<string> $content Optional content to be added as innerHTML. If an array is given, it gets converted into string
     * @param array $options Array of options
     * @return string
     */
    public static function node(string $tag, array $attrs = [], $content = '', array $options = []): string
    {
        return self::render(
            '<{{tag}} {{attrs}}>{{content}}</{{tag}}>',
            [
                'tag' => $tag,
                'attrs' => self::buildAttrs($attrs, $options),
                'content' => is_array($content) ? implode('', $content) : $content,
            ]
        );
    }

    public static function nodeOpen(string $tag, array $attrs = [], array $options = []): string
    {
        return self::render(
            '<{{tag}} {{attrs}}>',
            [
                'tag' => $tag,
                'attrs' => self::buildAttrs($attrs, $options),
            ]
        );
    }

    public static function nodeClose(string $tag): string
    {
        return self::render(
            '</{{tag}}>',
            [
                'tag' => $tag,
            ]
        );
    }

    /**
     * Build a space-delimited string with each HTML attribute generated.
     *
     * @param array $attrs
     * @param array<string, mixed> $options Array of options
     * @return string
     */
    public static function buildAttrs(array $attrs, array $options): string
    {
        $defaults = [
            'escape' => true,
        ];
        $options = $options + $defaults;

        $attributes = [];
        foreach ($attrs as $key => $value) {
            if (!empty($key) && $value !== null) {
                $attributes[] = self::__formatAttribute((string) $key, $value, $options['escape']);
            }
        }
        $html = trim(implode(' ', $attributes));
        return $html;
    }

    /**
     * Format an individual HTML attribute
     * Support minimized attributes such as `selected` and `disabled`
     *
     * @param string $key The name of the attribute
     * @param array<string>|string $value The value of the attribute
     * @param bool $escape Should the attribute value be escaped
     * @return string
     */
    public static function __formatAttribute(string $key, $value, bool $escape = true): string
    {
        $value = is_array($value) ? implode(' ', $value): $value;
        if (is_numeric($key)) {
            return sprintf('%s="%s"', h($value), (!empty($escape) ? h($value) : $value));
        }
        $isMinimized = isset(COMPACT_ATTRIBUTES[$key]);
        if ($isMinimized) {
            if (!empty($value)) {
                return sprintf('%s="%s"', h($key), (!empty($escape) ? h($value) : $value));
            }
            return '';
        } else if (!isset($value)) {
            return '';
        }
        return sprintf('%s="%s"', h($key), (!empty($escape) ? h($value) : $value));
    }

    protected static function genHTMLParams($params)
    {
        $html = '';
        foreach ($params as $k => $v) {
            if (!empty($k) && (isset($v) && $v !== '')) {
                $html .= BootstrapGeneric::genHTMLParam($k, $v) . ' ';
            }
        }
        return $html;
    }

    protected static function genHTMLParam($paramName, $values)
    {
        if (!is_array($values)) {
            $values = [$values];
        }
        return sprintf('%s="%s"', $paramName, implode(' ', $values));
    }

    protected static function convertToArrayIfNeeded($data): array
    {
        return is_array($data) ? $data : [$data];
    }

    protected static function genericCloseButton($dismissTarget)
    {
        return self::node('button', [
            'type' => 'button',
            'class' => 'btn-close',
            'data-bs-dismiss' => $dismissTarget,
            'arial-label' => __('Close')
        ]);
    }

    protected static function getTextClassForVariant(string $variant): string
    {
        return !empty(self::$textClassByVariants[$variant]) ? self::$textClassByVariants[$variant] : 'text-black';
    }

    protected static function getBGAndTextClassForVariant(string $variant): string
    {
        return sprintf('bg-%s %s', $variant, self::getTextClassForVariant($variant));
    }
}
