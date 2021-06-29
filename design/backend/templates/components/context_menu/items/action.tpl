{*
    $item_id string                             Item identifier
    $item    \Tygh\ContextMenu\Items\ActionItem Action item
    $data    array                              Data from context_menu schema
    $params  array                              Сontext menu component parameters
*}

<li {$data.menu_item_attributes|render_tag_attrs nofilter} class="btn bulk-edit__btn bulk-edit__btn--{$item_id} {$data.menu_item_class}">
    <span class="bulk-edit__btn-content">
        <a {$data.action_attributes|render_tag_attrs nofilter}
            class="cm-process-items cm-submit {$data.action_class}"
            data-ca-target-form="{$params.form}"
            data-ca-dispatch="dispatch[{$data.dispatch}]"
        >
            {__($data.name.template, $data.name.params)}
        </a>
    <span class="caret mobile-hide"></span></span>
</li>
