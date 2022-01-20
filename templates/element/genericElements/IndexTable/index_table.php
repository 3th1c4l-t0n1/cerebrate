<?php

use Cake\Utility\Text;
/*
     *  echo $this->element('/genericElements/IndexTable/index_table', [
     *      'top_bar' => (
     *          // search/filter bar information compliant with ListTopBar
     *      ),
     *      'data' => [
                // the actual data to be used
     *      ),
     *      'fields' => [
     *          // field list with information for the paginator, the elements used for the individual cells, etc
     *      ),
     *      'title' => optional title,
     *      'description' => optional description,
     *      'index_statistics' => optional statistics to be displayed for the index,
     *      'primary_id_path' => path to each primary ID (extracted and passed as $primary to fields)
     *  ));
     *
     */

$newMetaFields = [];
if (!empty($requestedMetaFields)) { // Create mapping for new index table fields on the fly
    foreach ($requestedMetaFields as $requestedMetaField) {
        $template_id = $requestedMetaField['template_id'];
        $meta_template_field_id = $requestedMetaField['meta_template_field_id'];
        $newMetaFields[] = [
            'name' => $meta_templates[$template_id]['meta_template_fields'][$meta_template_field_id]['field'],
            'data_path' => "MetaTemplates.{$template_id}.meta_template_fields.{$meta_template_field_id}.metaFields.{n}.value",
            'element' => 'generic_field',
            '_metafield' => true,
            '_automatic_field' => true,
        ];
    }
}
$data['fields'] = array_merge($data['fields'], $newMetaFields);

$tableRandomValue = Cake\Utility\Security::randomString(8);
echo '<div id="table-container-' . h($tableRandomValue) . '">';
if (!empty($data['title'])) {
    echo Text::insert(
        '<h2 class="fw-light">:title :help</h2>',
        [
            'title' => h($data['title']),
            'help' => $this->Bootstrap->icon('info', [
                'class' => ['fs-6', 'align-text-top',],
                'title' => empty($data['description']) ? '' : h($data['description']),
                'params' => [
                    'data-bs-toggle' => 'tooltip',
                ]
            ]),
        ]
    );
}

if(!empty($notice)) {
    echo $this->Bootstrap->alert($notice);
}

if (!empty($modelStatistics)) {
    echo $this->element('genericElements/IndexTable/Statistics/index_statistic_scaffold', [
        'statistics' => $modelStatistics,
    ]);
}


echo '<div class="panel">';
if (!empty($data['html'])) {
    echo sprintf('<div>%s</div>', $data['html']);
}
$skipPagination = isset($data['skip_pagination']) ? $data['skip_pagination'] : 0;
if (!$skipPagination) {
    $paginationData = !empty($data['paginatorOptions']) ? $data['paginatorOptions'] : [];
    echo $this->element(
        '/genericElements/IndexTable/pagination',
        [
            'paginationOptions' => $paginationData,
            'tableRandomValue' => $tableRandomValue
        ]
    );
    echo $this->element(
        '/genericElements/IndexTable/pagination_links'
    );
}
$multiSelectData = getMultiSelectData($data['top_bar']);
if (!empty($multiSelectData)) {
    $multiSelectField = [
        'element' => 'selector',
        'class' => 'short',
        'data' => $multiSelectData['data']
    ];
    array_unshift($data['fields'], $multiSelectField);
}
if (!empty($data['top_bar'])) {
    echo $this->element(
        '/genericElements/ListTopBar/scaffold',
        [
            'data' => $data['top_bar'],
            'table_data' => $data,
            'tableRandomValue' => $tableRandomValue
        ]
    );
}
$rows = '';
$row_element = isset($data['row_element']) ? $data['row_element'] : 'row';
$options = isset($data['options']) ? $data['options'] : [];
$actions = isset($data['actions']) ? $data['actions'] : [];
if ($this->request->getParam('prefix') === 'Open') {
    $actions = [];
}
$dblclickActionArray = !empty($actions) ? $this->Hash->extract($actions, '{n}[dbclickAction]') : [];
$dbclickAction = '';
foreach ($data['data'] as $k => $data_row) {
    $primary = null;
    if (!empty($data['primary_id_path'])) {
        $primary = $this->Hash->extract($data_row, $data['primary_id_path'])[0];
    }
    if (!empty($dblclickActionArray)) {
        $dbclickAction = sprintf("changeLocationFromIndexDblclick(%s)", $k);
    }
    $rows .= sprintf(
        '<tr data-row-id="%s" %s %s class="%s %s">%s</tr>',
        h($k),
        empty($dbclickAction) ? '' : 'ondblclick="' . $dbclickAction . '"',
        empty($primary) ? '' : 'data-primary-id="' . $primary . '"',
        empty($data['row_modifier']) ? '' : h($data['row_modifier']($data_row)),
        empty($data['class']) ? '' : h($data['row_class']),
        $this->element(
            '/genericElements/IndexTable/' . $row_element,
            [
                'k' => $k,
                'row' => $data_row,
                'fields' => $data['fields'],
                'options' => $options,
                'actions' => $actions,
                'primary' => $primary,
                'tableRandomValue' => $tableRandomValue
            ]
        )
    );
}
$tbody = '<tbody>' . $rows . '</tbody>';
echo sprintf(
    '<table class="table table-hover" id="index-table-%s" data-table-random-value="%s" data-reload-url="%s">%s%s</table>',
    $tableRandomValue,
    $tableRandomValue,
    h($this->Url->build(['action' => $this->request->getParam('action'),])),
    $this->element(
        '/genericElements/IndexTable/headers',
        [
            'fields' => $data['fields'],
            'paginator' => $this->Paginator,
            'actions' => (empty($actions) ? false : true),
            'tableRandomValue' => $tableRandomValue
        ]
    ),
    $tbody
);
if (!$skipPagination) {
    echo $this->element('/genericElements/IndexTable/pagination_counter', $paginationData);
    echo $this->element('/genericElements/IndexTable/pagination_links');
}
echo '</div>';
echo '</div>';
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#index-table-<?= $tableRandomValue ?>').data('data', <?= json_encode($data['data']) ?>);
        $('.privacy-toggle').on('click', function() {
            var $privacy_target = $(this).parent().find('.privacy-value');
            if ($(this).hasClass('fa-eye')) {
                $privacy_target.text($privacy_target.data('hidden-value'));
                $(this).removeClass('fa-eye');
                $(this).addClass('fa-eye-slash');
            } else {
                $privacy_target.text('****************************************');
                $(this).removeClass('fa-eye-slash');
                $(this).addClass('fa-eye');
            }
        });

        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>

<?php
function getMultiSelectData($topbar)
{
    foreach ($topbar['children'] as $child) {
        if (!empty($child['type']) && $child['type'] == 'multi_select_actions') {
            return $child;
        }
    }
    return [];
}
