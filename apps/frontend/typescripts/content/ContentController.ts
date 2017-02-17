/// <reference path="./../../../../typings/tsd.d.ts" />
module frontApp {
    interface IContentController{

    }

    class ContentController implements IContentController{


        public contents = [];

        constructor(private root , private scope, private window, private location, public contentService,public translate, private localStorageService, public content) {
            console.log(content);

        }


    }

    var frontApp = angular.module('frontApp');
    frontApp.controller('ContentController', ['$rootScope','$scope','$window','$location', 'ContentService','$translate', 'localStorageService','content', ContentController]);
}