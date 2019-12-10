<div class="totalpoll-tab-content active">
	<div class="totalpoll-settings-item">
		<div class="totalpoll-settings-field">
			<label class="totalpoll-settings-field-label">
				<?php _e( 'Title', 'totalpoll' ); ?>
			</label>
			<input type="text" class="totalpoll-settings-field-input widefat" ng-model="editor.settings.seo.poll.title">
		</div>
	</div>
	<div class="totalpoll-settings-item">
		<div class="totalpoll-settings-field">
			<label class="totalpoll-settings-field-label">
				<?php _e( 'Description', 'totalpoll' ); ?>
			</label>
			<textarea rows="3" class="totalpoll-settings-field-input widefat" maxlength="150" ng-model="editor.settings.seo.poll.description"></textarea>

			<p class="totalpoll-feature-tip">
				{{150 - editor.settings.seo.poll.description.length}}
				<?php _e( 'Characters left.', 'totalpoll' ); ?>
			</p>
		</div>
	</div>
	<div class="totalpoll-settings-item">
		<p><strong>
				<?php _e( 'Template variables', 'totalpoll' ); ?>
			</strong></p>
		<p class="totalpoll-feature-tip" ng-non-bindable>
			<?php _e( '{{title}} for poll title.', 'totalpoll' ); ?>
		</p>
		<p class="totalpoll-feature-tip" ng-non-bindable>
			<?php _e( '{{sitename}} for website title.', 'totalpoll' ); ?>
		</p>
	</div>
</div>