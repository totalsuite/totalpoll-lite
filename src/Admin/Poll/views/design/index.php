<customizer></customizer>
<!-- Template -->
<script type="text/ng-template" id="customizer-component-template">
    <div class="totalpoll-design" ng-attr-device="{{$ctrl.getDevice()}}">
		<?php include __DIR__ . '/sidebar.php'; ?>
		<?php include __DIR__ . '/preview.php'; ?>
    </div>
</script>
<script type="text/ng-template" id="customizer-tabs-component-template">
    <div class="totalpoll-design-tabs" ng-class="{'active': $ctrl.$customizer.hasActiveTabAfter($ctrl.getTarget())}" ng-transclude target="{{$ctrl.getTarget()}}"></div>
</script>
<script type="text/ng-template" id="customizer-tab-component-template">
    <div class="totalpoll-design-tabs-item"
         ng-click="$ctrl.$customizer.setActiveTab($ctrl.getTarget(), $event.currentTarget.firstChild.textContent.trim() || $event.currentTarget.children[0].textContent.trim())"
         ng-transclude target="{{$ctrl.getTarget()}}"></div>
</script>
<script type="text/ng-template" id="customizer-tab-content-component-template">
    <div class="totalpoll-design-tabs-content" ng-class="{'active': $ctrl.$customizer.hasActiveTab($ctrl.getTarget())}" ng-transclude target="{{$ctrl.getTarget()}}"></div>
</script>
<script type="text/ng-template" id="customizer-preview-body-template">
    <div id="totalpoll" class="totalpoll-wrapper <?php echo is_rtl() ? 'is-rtl' : 'is-ltr'; ?>" totalpoll-uid="demo" ng-include="$ctrl.getCurrentTemplatePreviewContentId()" ng-controller="PreviewCtrl as $preview"></div>
</script>
<script type="text/ng-template" id="customizer-preview-head-template">
    <meta ng-init="design = $root.settings.design">
    <meta ng-init="uid = 'demo'">
    <style type="text/css" ng-include="$ctrl.getCurrentTemplatePreviewCssId()"></style>
    <style type="text/css" ng-bind="design.css"></style>
    <style>
        * {
            vertical-align: baseline;
            box-sizing: border-box;
        }

        html, body {
            min-height: 100%;
        }

        body {
            height: min-content;
            margin: 0;
            padding: 1em;
            font-family: sans-serif;
        }
    </style>
</script>

<script type="text/ng-template" id="design-typography-template">
    <div class="totalpoll-settings-item">
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Font family', 'totalpoll' ); ?>
            </label>
            <input type="text" class="totalpoll-settings-field-input widefat" ng-model="$ctrl.settings.fontFamily">
        </div>
    </div>
    <div class="totalpoll-settings-item totalpoll-settings-item-inline">
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Font size', 'totalpoll' ); ?>
            </label>
            <input type="text" class="totalpoll-settings-field-input widefat" ng-model="$ctrl.settings.fontSize">
        </div>
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Line height', 'totalpoll' ); ?>
            </label>
            <input type="text" class="totalpoll-settings-field-input widefat" ng-model="$ctrl.settings.lineHeight">
        </div>
    </div>
    <div class="totalpoll-settings-item totalpoll-settings-item-inline">
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Align', 'totalpoll' ); ?>
            </label>
            <select class="totalpoll-settings-field-input widefat" ng-model="$ctrl.settings.align">
                <option value="inherit" ng-selected="$ctrl.settings.align == 'inherit'">
					<?php _e( 'Inherit', 'totalpoll' ); ?>
                </option>
                <option value="right" ng-selected="$ctrl.settings.align == 'right'">
					<?php _e( 'Right', 'totalpoll' ); ?>
                </option>
                <option value="center" ng-selected="$ctrl.settings.align == 'center'">
					<?php _e( 'Center', 'totalpoll' ); ?>
                </option>
                <option value="left" ng-selected="$ctrl.settings.align == 'left'">
					<?php _e( 'Left', 'totalpoll' ); ?>
                </option>
            </select>
        </div>
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Transform', 'totalpoll' ); ?>
            </label>
            <select class="totalpoll-settings-field-input widefat"
                    ng-model="$ctrl.settings.transform">
                <option value="none" ng-selected="$ctrl.settings.transform == 'inherit'">
					<?php _e( 'Inherit', 'totalpoll' ); ?>
                </option>
                <option value="none" ng-selected="$ctrl.settings.transform == 'none'">
					<?php _e( 'Normal', 'totalpoll' ); ?>
                </option>
                <option value="uppercase" ng-selected="$ctrl.settings.transform == 'uppercase'">
					<?php _e( 'UPPERCASE', 'totalpoll' ); ?>
                </option>
                <option value="lowercase" ng-selected="$ctrl.settings.transform == 'lowercase'">
					<?php _e( 'lowercase', 'totalpoll' ); ?>
                </option>
                <option value="capitalize" ng-selected="$ctrl.settings.transform == 'capitalize'">
					<?php _e( 'Capitalize', 'totalpoll' ); ?>
                </option>
            </select>
        </div>
    </div>
</script>
<script type="text/ng-template" id="design-padding-template">
    <div class="totalpoll-settings-item">
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Top', 'totalpoll' ); ?>
            </label>
            <input type="text" class="totalpoll-settings-field-input widefat"
                   ng-model="$ctrl.settings.top">
        </div>
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Right', 'totalpoll' ); ?>
            </label>
            <input type="text" class="totalpoll-settings-field-input widefat"
                   ng-model="$ctrl.settings.right">
        </div>
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Bottom', 'totalpoll' ); ?>
            </label>
            <input type="text" class="totalpoll-settings-field-input widefat"
                   ng-model="$ctrl.settings.bottom">
        </div>
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Left', 'totalpoll' ); ?>
            </label>
            <input type="text" class="totalpoll-settings-field-input widefat"
                   ng-model="$ctrl.settings.left">
        </div>
    </div>

</script>

<script type="text/ng-template" id="customizer-control-component-template">
    <ng-include src="$ctrl.getTemplate()"></ng-include>
</script>
<script type="text/ng-template" id="customizer-control-text-template">
    <div class="totalpoll-settings-item">
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label" ng-if="$ctrl.label">{{ $ctrl.label }}</label>
            <input type="text" class="totalpoll-settings-field-input widefat" ng-model="$ctrl.ngModel">
        </div>
    </div>
</script>
<script type="text/ng-template" id="customizer-control-select-template">
    <div class="totalpoll-settings-item">
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label" ng-if="$ctrl.label">{{ $ctrl.label }}</label>
            <select name="" class="totalpoll-settings-field-input widefat" ng-model="$ctrl.ngModel" ng-options="value as label for (value, label) in $ctrl.options"></select>
        </div>
    </div>
</script>
<script type="text/ng-template" id="customizer-control-checkbox-template">
    <div class="totalpoll-settings-item">
        <div class="totalpoll-settings-field">
            <label>
                <input type="checkbox" name="" ng-model="$ctrl.ngModel" ng-checked="$ctrl.ngModel">
                {{ $ctrl.label }}
                <span class="totalpoll-feature-details" ng-if="$ctrl.help" tooltip="{{ $ctrl.help }}">?</span>
            </label>
        </div>
    </div>
</script>
<script type="text/ng-template" id="customizer-control-color-template">
    <div class="totalpoll-settings-item">
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label" ng-if="$ctrl.label">{{ $ctrl.label }}</label>
            <input type="text" color-picker class="totalpoll-settings-field-input widefat" ng-model="$ctrl.ngModel">
        </div>
    </div>
</script>
<script type="text/ng-template" id="customizer-control-number-template">
    <div class="totalpoll-settings-item">
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label" ng-if="$ctrl.label">{{ $ctrl.label }}</label>
            <input type="number"
                   class="totalpoll-settings-field-input widefat"
                   ng-attr-min="{{$ctrl.options.min}}"
                   ng-attr-max="{{$ctrl.options.max}}"
                   ng-attr-step="{{$ctrl.options.step}}"
                   ng-model="$ctrl.ngModel">
        </div>
    </div>
</script>
<script type="text/ng-template" id="customizer-control-typography-template">
    <div class="totalpoll-settings-item">
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Font family', 'totalpoll' ); ?>
            </label>
            <input type="text" class="totalpoll-settings-field-input widefat" ng-model="$ctrl.ngModel.fontFamily">
        </div>
    </div>
    <div class="totalpoll-settings-item totalpoll-settings-item-inline">
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Font size', 'totalpoll' ); ?>
            </label>
            <input type="text" class="totalpoll-settings-field-input widefat" ng-model="$ctrl.ngModel.fontSize">
        </div>
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Line height', 'totalpoll' ); ?>
            </label>
            <input type="text" class="totalpoll-settings-field-input widefat" ng-model="$ctrl.ngModel.lineHeight">
        </div>
    </div>
    <div class="totalpoll-settings-item totalpoll-settings-item-inline">
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Align', 'totalpoll' ); ?>
            </label>
            <select class="totalpoll-settings-field-input widefat" ng-model="$ctrl.ngModel.align">
                <option value="inherit" ng-selected="$ctrl.ngModel.align == 'inherit'">
					<?php _e( 'Inherit', 'totalpoll' ); ?>
                </option>
                <option value="right" ng-selected="$ctrl.ngModel.align == 'right'">
					<?php _e( 'Right', 'totalpoll' ); ?>
                </option>
                <option value="center" ng-selected="$ctrl.ngModel.align == 'center'">
					<?php _e( 'Center', 'totalpoll' ); ?>
                </option>
                <option value="left" ng-selected="$ctrl.ngModel.align == 'left'">
					<?php _e( 'Left', 'totalpoll' ); ?>
                </option>
            </select>
        </div>
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Transform', 'totalpoll' ); ?>
            </label>
            <select class="totalpoll-settings-field-input widefat"
                    ng-model="$ctrl.ngModel.transform">
                <option value="none" ng-selected="$ctrl.ngModel.transform == 'none'">
					<?php _e( 'Normal', 'totalpoll' ); ?>
                </option>
                <option value="uppercase" ng-selected="$ctrl.ngModel.transform == 'uppercase'">
					<?php _e( 'UPPERCASE', 'totalpoll' ); ?>
                </option>
                <option value="lowercase" ng-selected="$ctrl.ngModel.transform == 'lowercase'">
					<?php _e( 'lowercase', 'totalpoll' ); ?>
                </option>
                <option value="capitalize" ng-selected="$ctrl.ngModel.transform == 'capitalize'">
					<?php _e( 'Capitalize', 'totalpoll' ); ?>
                </option>
            </select>
        </div>
    </div>
</script>
<script type="text/ng-template" id="customizer-control-border-template">
    <div class="totalpoll-settings-item">
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Width', 'totalpoll' ); ?>
            </label>
            <input type="text" class="totalpoll-settings-field-input widefat" ng-model="$ctrl.ngModel.width">
        </div>
    </div>
    <div class="totalpoll-settings-item">
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Style', 'totalpoll' ); ?>
            </label>
            <select class="totalpoll-settings-field-input widefat" ng-model="$ctrl.ngModel.style">
                <option value="inherit" ng-selected="$ctrl.ngModel.align == 'inherit'">
					<?php _e( 'Inherit', 'totalpoll' ); ?>
                </option>
                <option value="none" ng-selected="$ctrl.ngModel.align == 'none'">
					<?php _e( 'None', 'totalpoll' ); ?>
                </option>
                <option value="solid" ng-selected="$ctrl.ngModel.align == 'solid'">
					<?php _e( 'Solid', 'totalpoll' ); ?>
                </option>
                <option value="double" ng-selected="$ctrl.ngModel.align == 'double'">
					<?php _e( 'Double', 'totalpoll' ); ?>
                </option>
                <option value="dashed" ng-selected="$ctrl.ngModel.align == 'dashed'">
					<?php _e( 'Dashed', 'totalpoll' ); ?>
                </option>
                <option value="dotted" ng-selected="$ctrl.ngModel.align == 'dotted'">
					<?php _e( 'Dotted', 'totalpoll' ); ?>
                </option>
                <option value="groove" ng-selected="$ctrl.ngModel.align == 'groove'">
					<?php _e( 'Groove', 'totalpoll' ); ?>
                </option>
                <option value="hidden" ng-selected="$ctrl.ngModel.align == 'hidden'">
					<?php _e( 'Hidden', 'totalpoll' ); ?>
                </option>
                <option value="ridge" ng-selected="$ctrl.ngModel.align == 'ridge'">
					<?php _e( 'Ridge', 'totalpoll' ); ?>
                </option>
            </select>
        </div>
    </div>
    <div class="totalpoll-settings-item">
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Radius', 'totalpoll' ); ?>
            </label>
            <input type="text" class="totalpoll-settings-field-input widefat" ng-model="$ctrl.ngModel.radius">
        </div>
    </div>
</script>
<script type="text/ng-template" id="customizer-control-padding-template">
    <div class="totalpoll-settings-item">
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Top', 'totalpoll' ); ?>
            </label>
            <input type="text" class="totalpoll-settings-field-input widefat" ng-model="$ctrl.ngModel.top">
        </div>
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Right', 'totalpoll' ); ?>
            </label>
            <input type="text" class="totalpoll-settings-field-input widefat" ng-model="$ctrl.ngModel.right">
        </div>
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Bottom', 'totalpoll' ); ?>
            </label>
            <input type="text" class="totalpoll-settings-field-input widefat" ng-model="$ctrl.ngModel.bottom">
        </div>
        <div class="totalpoll-settings-field">
            <label class="totalpoll-settings-field-label">
				<?php _e( 'Left', 'totalpoll' ); ?>
            </label>
            <input type="text" class="totalpoll-settings-field-input widefat" ng-model="$ctrl.ngModel.left">
        </div>
    </div>
</script>
