<?php $customization = apply_filters( 'totalpoll/filters/admin/editor/templates/customization', true ); ?>
    <customizer-tabs>
        <customizer-tab ng-repeat="template in $ctrl.getTemplates()" target="{{ template.id }}">
            {{ template.name }}
            <button type="button" class="button button-small"
                    ng-class="{'button-primary': $ctrl.isTemplate(template.id)}"
                    ng-disabled="$ctrl.isTemplate(template.id)"
                    ng-click="$ctrl.changeTemplateTo(template, $event)">
                <span ng-if="!$ctrl.isTemplate(template.id)"><?php _e( 'Use', 'totalpoll' ); ?></span>
                <span ng-if="$ctrl.isTemplate(template.id)"><?php _e( 'Active', 'totalpoll' ); ?></span>
            </button>
        </customizer-tab>
		<?php if ( $customization ): ?>
            <customizer-tab target="customized-template"><?php _e( 'Customized Template', 'totalpoll' ); ?></customizer-tab>
		<?php endif; ?>
    </customizer-tabs>

    <customizer-tab-content ng-repeat="template in $ctrl.getTemplates()" name="{{template.id}}" class="totalpoll-design-tabs-content-template">
        <div class="totalpoll-design-tabs-content-template-image">
            <img ng-src="{{template.images.cover}}" ng-attr-alt="{{template.name}}">
        </div>
        <div class="totalpoll-design-tabs-content-template-description" ng-bind="template.description"></div>
        <div class="totalpoll-design-tabs-content-template-meta">
            <div>
				<?php _e( 'By', 'totalpoll' ); ?>
                <a ng-href="{{template.author.url}}" target="_blank">{{template.author.name}}</a>
                &nbsp;&bullet;&nbsp;<?php _e( 'Version', 'totalpoll' ); ?>
                : {{template.version}}
            </div>

            <button type="button" class="button button-small"
                    ng-class="{'button-primary': $ctrl.isTemplate(template.id)}"
                    ng-disabled="$ctrl.isTemplate(template.id)"
                    ng-click="$ctrl.changeTemplateTo(template, $event)">
                <span ng-if="!$ctrl.isTemplate(template.id)"><?php _e( 'Use', 'totalpoll' ); ?></span>
                <span ng-if="$ctrl.isTemplate(template.id)"><?php _e( 'Active', 'totalpoll' ); ?></span>
            </button>
        </div>
    </customizer-tab-content>
<?php if ( $customization ): ?>
    <customizer-tab-content name="customized-template" class="totalpoll-design-tabs-content-template">
        <div class="totalpoll-design-tabs-content-template-image">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAAEsCAMAAAAo4z2kAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAqFBMVEUAc6ozj7uIvtfG4Ozt9fn////r9PiHvdcyjru/3Oq92+kxjroBdKp8t9P7/f56ttMDdauizOCfyt+Wxdxrrs5prc0hhbX3+/z1+vynz+KlzuEdg7T9/v4bgrN0s9FxsdCz1eaw1OXe7fTb6/Pz+Pvw9/rd7PT5/P3S5vDx9/oRfLDV6PG72ui31+eoz+IihrVsrs5qrc2gy999uNR7t9OJvtjH4Ozu9vmXkUMbAAAAAWJLR0QF+G/pxwAAAAd0SU1FB+EMHxYqOfSDU60AAALkSURBVHja7dvJblNREEVRTLi0wQQCoQtNiOn7/v//DIiEZAYwAJ8cdLPW+OlJVbXlgaV36hQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAB/bXF668w4Pme3zi3aI5N3/sIxRvXTxUvtscnavrwsdDXG8sp2e3SCdq5Wsvrh2k57eHJ2a12Nsdsenpjrxa7GuNEen5C9m9Wwbu21F0DG7WpXY9xpL4CIu/vlsJb32isg4X65qzEetFdAwsN2V+OgvQISHrW7GoftFZCwanc1HrdXQEI7q+/aKyChXZWwJtWuSliTalclrEm1qxLWpNpVCWtS7aqENal2VcKaVLsqYU2qXZWwJtWuSliTalclrEm1qxLWpNpVCWtS7aqENal2VcKaVLsqYU2qXZWwJtWuSliTWr/w/pMNeXr0utXvH9gX1uzWL7yxzxqeHb3uD984PxbW7IRFhLCIEBYRwiJCWEQIiwhhESEsIoRFhLCIEBYRwiJCWEQIiwhhESEsIoRFhLCIEBYRwiJCWEQIiwhhESEsItYv/PzFhrwU1ok3coR1kgmLCGERISwihEWEsIhYv/Dy1YashHXirV/YH6RsjLCIEBYRwiJCWEQIiwhhESEsIoRFhLCIEBYRwiJCWEQIiwhhESEsIoRFhLCIEBYRwiJCWEQIiwhhESEsIoRFxPqFV4sNOTx63evfP7AS1ux+OXHFxn4n+Z88anc1DtsrIOFhu6tx0F4BCffbXY0H7RWQcHe/3NXyXnsFRLwph3Xn30fgf/T2ZrWrW3vtBRDyrhrW+/b4xOwWu9ptD0/OztVaVx922sMTtP1xWclq+Wm7PTpZiwuFri5eao9N3uLzl6/HGNXXrc+L9sgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAHBcvgH7refzh93x/QAAAABJRU5ErkJggg=="
                 alt="<?php _e( 'Customized Template', 'totalpoll' ); ?>">
        </div>
        <div class="totalpoll-design-tabs-content-template-description">Our experts can design and develop tailored templates that suits your needs.</div>
        <div class="totalpoll-design-tabs-content-template-meta">
            <div>
				<?php _e( 'Customization service', 'totalpoll' ); ?>
            </div>


			<?php
			$url = add_query_arg(
				[
					'utm_source'   => 'in-app',
					'utm_medium'   => 'editor-design-tab',
					'utm_campaign' => 'totalpoll',
				],
				$this->env['links.customization']
			);
			?>
            <a href="<?php echo esc_attr( $url ); ?>" target="_blank" class="button button-primary button-small"><?php _e( 'Get Quote', 'totalpoll' ); ?></a>
        </div>
    </customizer-tab-content>
<?php endif; ?>