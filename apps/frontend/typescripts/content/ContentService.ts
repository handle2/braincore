/// <reference path="./../../../../typings/tsd.d.ts" />

module frontApp{

    interface IContentService{

    }
    export class ContentService implements IContentService{
        
        constructor(private rootScope,private location,private window,private http,private localStorageService){
            
        }
        
    }

    var frontApp = angular.module('frontApp');


    frontApp.service('ContentService', ['$rootScope','$location','$window','$http','localStorageService', function(rootScope,location,window,http,localStorageService){
        return new ContentService(rootScope,location,window,http,localStorageService);
    }]);
}
