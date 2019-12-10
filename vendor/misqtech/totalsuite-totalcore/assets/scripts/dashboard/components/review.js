var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
///<reference path="../../common/decorators.ts"/>
///<reference path="../../common/providers/settings.ts"/>
var TotalCore;
(function (TotalCore) {
    var Dashboard;
    (function (Dashboard) {
        var Components;
        (function (Components) {
            var Component = TotalCore.Common.Component;
            var DashboardReviewComponent = /** @class */ (function () {
                function DashboardReviewComponent(SettingsService) {
                    this.SettingsService = SettingsService;
                    this.randomTweet = '';
                }
                DashboardReviewComponent.prototype.$onInit = function () {
                    this.randomTweet = this.getRandomTweet();
                };
                DashboardReviewComponent.prototype.getRandomTweet = function () {
                    return this.SettingsService.presets['tweets'][Math.floor(Math.random() * this.SettingsService.presets['tweets'].length)];
                };
                DashboardReviewComponent = __decorate([
                    Component('components.dashboard', {
                        templateUrl: 'dashboard-review-component-template',
                        bindings: {}
                    })
                ], DashboardReviewComponent);
                return DashboardReviewComponent;
            }());
        })(Components = Dashboard.Components || (Dashboard.Components = {}));
    })(Dashboard = TotalCore.Dashboard || (TotalCore.Dashboard = {}));
})(TotalCore || (TotalCore = {}));
