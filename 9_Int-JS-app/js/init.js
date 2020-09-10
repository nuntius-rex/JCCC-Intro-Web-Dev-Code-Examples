requirejs.config({
    //By default load any module IDs from js/lib
    baseUrl: 'js/lib',
    //except, if the module ID starts with "app",
    //load it from the js/app directory. paths
    //config is relative to the baseUrl, and
    //never includes a ".js" extension since
    //the paths config could be for a directory.
    paths: {
        app: '../app',
        debug: '../debug'
    }
});

require([
  'knockout-3.4.2',
  'app/appViewModel',
  'domReady!',
  'jquery.min',
  'debug/debugger'
],function(ko, appViewModel) { //Note the two libraries instantiated by the factory method
    ko.applyBindings(new appViewModel()); //init the knockout binding
    console.log("Init complete.");
});
