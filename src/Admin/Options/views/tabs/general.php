<div class="totalpoll-settings-item totalpoll-pro-badge-container">
    <div class="totalpoll-settings-field">
        <label>
            <input type="checkbox" name="" ng-model="$ctrl.options.general.structuredData.enabled">
			<?php _e( 'Structured Data', 'totalpoll' ); ?>
        </label>

        <p class="totalpoll-feature-tip"><?php _e( 'Improve your appearance in search engine through <a href="https://developers.google.com/search/docs/guides/intro-structured-data" target="_blank">Structured Data</a> implementation..', 'totalpoll' ); ?></p>
    </div>
    <?php TotalPoll( 'upgrade-to-pro' ); ?>
</div>
