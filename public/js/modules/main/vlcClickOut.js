/**
 * Created by jacsiel on 13/09/16.
 *
 * this is a modification of angular-clickOut library, of ! Angular clickout v1.0.2 | © 2014 Greg Bergé | License MIT
 */
(function (window, angular, undefined) { 'use strict';

    /**
     * Click out directive.
     * Execute an angular expression when we click out of the current element.
     */

    angular.module('vlcClickOut', [])
        .directive('clickOut', ['$window', '$parse', function ($window, $parse) {
            return {
                restrict: 'A',
                link: function (scope, element, attrs) {
                    var clickOutHandler = $parse(attrs.clickOut);

                    angular.element($window).on('click', function (event) {
                        if (element[0].contains(event.target)) return;

                        //console.log(event)
                        //start Jacsiel Code*/
                            /*the follow, if, is add for especific exceptions in LAMBU system,
                                on click in .popUp class (this is a class of layer with extra informations
                                or click in #layrAlert that is a layer for alerts or notifications
                                or click in md-autocomplete-suggestions tht is of elements of virtual-list create by md-autocomplete
                                thesse cases, click out is disabled for default, and return void
                             */
                        if((angular.element(event.target).parents(".popUp").length>0)
                            || (angular.element(event.target).parents("#lyrAlert").length>0)
                            || (angular.element(event.target).is("[ngf-select]"))
                            || (angular.element(event.target).parents("#lyrAlert").length>0)
                            || (angular.element(event.target).parents(".md-autocomplete-suggestions").length>0)
                            || (angular.element(event.target).parents(".md-calendar-month-label").length>0)
                            || (angular.element(event.target).parents(".md-calendar-date").length>0)){
                            //console.log("igonrado==>",angular.element(event.target))
                            return;
                        }

                        /*end Jacsiel code*/
                        clickOutHandler(scope, {$event: event});
                        scope.$apply();
                    });
                }
            };
        }]);

}(window, window.angular));
