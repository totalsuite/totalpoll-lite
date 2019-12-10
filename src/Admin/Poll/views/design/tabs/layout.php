<customizer-control
	type="number"
	label="<?php _e( 'Choices per row', 'totalpoll' ); ?>"
	ng-model="$root.settings.design.layout.choicesPerRow"
	options="{min: 1, max: 12, step: 1}"></customizer-control>
<customizer-control
	type="number"
	label="<?php _e( 'Questions per row', 'totalpoll' ); ?>"
	ng-model="$root.settings.design.layout.questionsPerRow"
	options="{min: 1, max: 4, step: 1}"></customizer-control>
<customizer-control
	type="text"
	label="<?php _e( 'Maximum width', 'totalpoll' ); ?>"
	ng-model="$root.settings.design.layout.maxWidth"></customizer-control>
<customizer-control
	type="text"
	label="<?php _e( 'Gutter', 'totalpoll' ); ?>"
	ng-model="$root.settings.design.layout.gutter"></customizer-control>
<customizer-control
        type="text"
        label="<?php _e( 'Border Radius', 'totalpoll' ); ?>"
        ng-model="$root.settings.design.layout.radius"></customizer-control>