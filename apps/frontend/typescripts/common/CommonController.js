/// <reference path="./../../../../typings/tsd.d.ts" />
var frontApp;
(function (frontApp_1) {
    var CommonController = (function () {
        function CommonController(root, scope, window, location, commonService, translate, localStorageService) {
            this.root = root;
            this.scope = scope;
            this.window = window;
            this.location = location;
            this.commonService = commonService;
            this.translate = translate;
            this.localStorageService = localStorageService;
            if (!localStorageService.get('lang')) {
                localStorageService.set('lang', 'hu');
                translate.use(localStorageService.get('lang'));
            }
            else {
                translate.use(localStorageService.get('lang'));
            }
            this.setLangSession(localStorageService.get('lang'));
            root.language = localStorageService.get('lang');
        }
        CommonController.prototype.hasPermission = function (code) {
            return this.commonService.hasPermission(code);
        };
        CommonController.prototype.changeLang = function (langKey) {
            if (this.localStorageService.get('lang') != langKey) {
                this.localStorageService.set('lang', langKey);
                this.translate.use(langKey);
                this.setLangSession(langKey);
                this.root.language = this.localStorageService.get('lang');
            }
            var currentUrl = this.location.path();
            this.window.open(currentUrl, '_self');
        };
        CommonController.prototype.setLangSession = function (code) {
            this.commonService.http.post('/admin/language/setLang', angular.toJson(code));
        };
        return CommonController;
    }());
    var frontApp = angular.module('frontApp');
    frontApp.controller('CommonController', ['$rootScope', '$scope', '$window', '$location', 'CommonService', '$translate', 'localStorageService', CommonController]);
})(frontApp || (frontApp = {}));
//# sourceMappingURL=CommonController.js.map