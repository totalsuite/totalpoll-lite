<div class="totalpoll-translations totalpoll-pro-badge-container" ng-controller="TranslationsCtrl as $ctrl">
    <table class="wp-list-table widefat totalpoll-translations-table">
        <thead>
        <tr>
            <th>
				<?php _e( 'Original', 'totalpoll' ); ?>
            </th>
            <th>
                <select name="" class="widefat" ng-options="language as language.name for language in editor.languages" ng-model="$ctrl.language">
                    <option value="">
						<?php _e( 'Select language', 'totalpoll' ); ?>
                    </option>
                </select>
            </th>
        </tr>
        </thead>
        <tbody ng-if="$ctrl.language">
        <tr ng-repeat-start="question in editor.settings.questions">
            <td colspan="2">
				<?php _e( 'Question #{{$index+1}}', 'totalpoll' ); ?>
            </td>
        </tr>
        <tr ng-if="question.content.length">
            <td>{{question.content}}</td>
            <td>
                <textarea name="" rows="1" class="widefat"
                          ng-style="{direction: $ctrl.language.direction}"
                          ng-model="question.translations[$ctrl.language.code].content" placeholder="{{question.content}}"></textarea>
            </td>
        </tr>
        <tr ng-repeat="choice in question.choices" ng-if="choice.label.length">
            <td>{{choice.label}}</td>
            <td>
                <input type="text" name="" class="widefat"
                       ng-style="{direction: $ctrl.language.direction}"
                       ng-model="choice.translations[$ctrl.language.code].label" placeholder="{{ choice.label }}">
            </td>
        </tr>
        <tr ng-repeat-end></tr>
        <tr>
            <td colspan="2">
				<?php _e( 'Fields', 'totalpoll' ); ?>
            </td>
        </tr>
        <tr ng-repeat="field in editor.settings.fields" ng-if="field.label.length">
            <td>{{field.label}}</td>
            <td>
                <p>
                    <input type="text" name="" class="widefat"
                           ng-style="{direction: $ctrl.language.direction}"
                           ng-model="field.translations[$ctrl.language.code].label" placeholder="{{field.label}}">
                </p>
                <!-- options -->
                <p ng-repeat="($key, option) in field.translations[$ctrl.language.code].options">
                    <input type="text" ng-model="field.translations[$ctrl.language.code].options[$key]" class="widefat" placeholder="{{ $ctrl.placeholders[field.uid.concat('-', $key)] }}">
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="2">
				<?php _e( 'Content', 'totalpoll' ); ?>
            </td>
        </tr>
        <tr ng-if="editor.settings.content.welcome.content.length">
            <td>{{editor.settings.content.welcome.content}}</td>
            <td>
                <textarea name="" rows="1" class="widefat"
                          ng-style="{direction: $ctrl.language.direction}"
                          ng-model="editor.settings.content.welcome.translations[$ctrl.language.code].content"></textarea>
            </td>
        </tr>
        <tr ng-if="editor.settings.content.vote.above.length">
            <td>{{editor.settings.content.vote.above}}</td>
            <td>
                <textarea name="" rows="1" class="widefat"
                          ng-style="{direction: $ctrl.language.direction}"
                          ng-model="editor.settings.content.vote.translations[$ctrl.language.code].above"></textarea>
            </td>
        </tr>
        <tr ng-if="editor.settings.content.vote.below.length">
            <td>{{editor.settings.content.vote.below}}</td>
            <td>
                <textarea name="" rows="1" class="widefat"
                          ng-style="{direction: $ctrl.language.direction}"
                          ng-model="editor.settings.content.vote.translations[$ctrl.language.code].below"></textarea>
            </td>
        </tr>
        <tr ng-if="editor.settings.content.thankyou.content.length">
            <td>{{editor.settings.content.thankyou.content}}</td>
            <td>
                <textarea name="" rows="1" class="widefat"
                          ng-style="{direction: $ctrl.language.direction}"
                          ng-model="editor.settings.content.thankyou.translations[$ctrl.language.code].content"></textarea>
            </td>
        </tr>
        <tr ng-if="editor.settings.content.results.content.length">
            <td>{{editor.settings.content.results.above}}</td>
            <td>
                <textarea name="" rows="1" class="widefat"
                          ng-style="{direction: $ctrl.language.direction}"
                          ng-model="editor.settings.content.results.translations[$ctrl.language.code].above"></textarea>
            </td>
        </tr>
        <tr ng-if="editor.settings.content.results.below.length">
            <td>{{editor.settings.content.results.below}}</td>
            <td>
                <textarea name="" rows="1" class="widefat"
                          ng-style="{direction: $ctrl.language.direction}"
                          ng-model="editor.settings.content.results.translations[$ctrl.language.code].below"></textarea>
            </td>
        </tr>
        <tr ng-if="editor.settings.results.message.length">
            <td>{{editor.settings.results.message}}</td>
            <td>
                <textarea name="" rows="1" class="widefat"
                          ng-style="{direction: $ctrl.language.direction}"
                          ng-model="editor.settings.results.translations[$ctrl.language.code].message"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2">
				<?php _e( 'SEO', 'totalpoll' ); ?>
            </td>
        </tr>
        <tr ng-if="editor.settings.seo.poll.title.length">
            <td>{{editor.settings.seo.poll.title}}</td>
            <td>
                <input type="text" name="" class="widefat"
                       ng-style="{direction: $ctrl.language.direction}"
                       ng-model="editor.settings.seo.poll.translations[$ctrl.language.code].title">
            </td>
        </tr>
        <tr ng-if="editor.settings.seo.poll.description.length">
            <td>{{editor.settings.seo.poll.description}}</td>
            <td>
                <textarea name="" rows="1" class="widefat"
                          ng-style="{direction: $ctrl.language.direction}"
                          ng-model="editor.settings.seo.poll.translations[$ctrl.language.code].description"></textarea>
            </td>
        </tr>
        </tbody>
    </table>
    <?php TotalPoll( 'upgrade-to-pro' ); ?>
</div>
