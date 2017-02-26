/// <reference path="./../../../typings/tsd.d.ts" />
module frontApp{

    var frontApp = angular.module('frontApp',["ngRoute","LocalStorageModule","smart-table","ui.bootstrap","uiSwitch","angular-img-cropper","pascalprecht.translate","angular-loading-bar","jkuri.datepicker","angularModalService"]); //,"ngImgCrop"

    frontApp.config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
        cfpLoadingBarProvider.includeSpinner = false;
    }]);


    /**
     * beállítunk alap headert a requestekhez
     */
    frontApp.config(['$httpProvider', function ($httpProvider) {
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
        $httpProvider.defaults.headers.post['Accept'] = 'application/json, text/javascript';
        $httpProvider.defaults.headers.post['Content-Type'] = 'application/json; charset=utf-8';
        $httpProvider.defaults.headers.post['Access-Control-Max-Age'] = '1728000';
        $httpProvider.defaults.headers.common['Access-Control-Max-Age'] = '1728000';
        $httpProvider.defaults.headers.common['Accept'] = 'application/json, text/javascript';
        $httpProvider.defaults.headers.common['Content-Type'] = 'application/json; charset=utf-8';
        $httpProvider.defaults.useXDomain = true;

    }]);



    frontApp.config(function ($routeProvider,$locationProvider,localStorageServiceProvider,$translateProvider,$httpProvider) {


        $translateProvider.useSanitizeValueStrategy('escapeParameters');

        $translateProvider.useStaticFilesLoader({
            prefix: '/apps/frontend/lang/',
            suffix: '.json'
        });

        // todo config itt kell beállítani a default nyelvet
        $translateProvider.preferredLanguage('hu');

        /**
         * locale storage beállítása
         */
        localStorageServiceProvider
            .setPrefix('frontApp');

        /**
         * angularos # kikapcsolása urlből
         */
        $locationProvider.html5Mode({
            enabled: true,
            requireBase: false
        });

        /**
         * request headerben betesszük a locale storageban tárolt auth tokent
         */
        $httpProvider.interceptors.push(['localStorageService',function (localStorageService) {
            return {
                'request': function (config) {
                    config.headers = config.headers || {};
                    if (localStorageService.get('front-hash')) {
                        config.headers.XFrontAuth = localStorageService.get('front-hash')?localStorageService.get('front-hash'):'not_auth';
                    }
                    return config;
                }
            }
        }]);

        /**
         * routing
         */
        $routeProvider.when("/", {
            templateUrl : '/apps/frontend/views/directives/routes/index/index.html'
        })
        .when("/login", {
            templateUrl : '/apps/frontend/views/directives/routes/login/login.html'
        })
        .when("/register", {
            templateUrl : '/apps/frontend/views/directives/routes/login/register.html'
        })
        .when("/content/:url", {
            templateUrl : '/apps/frontend/views/directives/routes/content/content.html',
            controller : 'ContentController',
            controllerAs: 'ctrl',
            resolve:	{
                content:	["$route","$http", function(route,http) {
                    return http.get('/content/get/'+route.current.params.url).then(function successCallback(response) {
                        return response.data;
                    });
                }],
            }
        })
        .when("/list/:url", {
            templateUrl : '/apps/frontend/views/directives/routes/content/list.html',
            controller : 'ContentController',
            controllerAs: 'ctrl',
            resolve:	{
                content:	["$route","$http", function(route,http) {
                    return http.get('/content/get/'+route.current.params.url).then(function successCallback(response) {
                        return response.data;
                    });
                }],
            }
        })

    });

}