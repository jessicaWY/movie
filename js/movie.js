/**
 * Created by Administrator on 2016/8/8.
 */
var app=angular.module('shangyingla',['ng','ngRoute']);

app.controller('parentCtrl',function($scope,$location){
    $scope.jump=function(path){
        $location.path(path);
    }
});
app.controller('mainCtrl', function ($scope, $http) {
    $scope.hasMore = true;
    $http.get('data/movie_getbypage.php?start=0')
        .success(function (data) {
            $scope.movieList = data;
        });
    $scope.loadMore = function () {
        $http('data/movie_getbypage.php?start='+$scope.movieList.length)
            .success(function (data) {
                if(data.length < 5)
                {
                    $scope.hasMore = false;
                }
                $scope.movieList = $scope.movieList.concat(data);
            });
    }
    $scope.$watch('kw', function () {
        console.log($scope.kw);
        if($scope.kw)
        {
            $http.get('data/movie_getbykw.php?kw='+$scope.kw)
                .success(function (data) {
                    console.log(data);
                    $scope.movieList = data;
                });
        }
    })
});
app.controller('detailCtrl',function($scope,$http,$routeParams){
    console.log($routeParams.mid);
    $http.get('data/movie_getbyid.php?id='+$routeParams.mid).success(function(data){
        $scope.movie=data;
        $scope.movie.mid=$routeParams.mid;
    })
});
app.controller('orderCtrl',function($scope,$http,$routeParams,$rootScope){
    console.log($routeParams.mid);
    $scope.submitOrder=function(){
        $scope.user.mid=$routeParams.mid;
        var str=jQuery.param($scope.user);
        console.log(str);
        $http.get('data/order_add.php?'+str).success(function(data){
            console.log(data);
            if(data.msg=='succ'){
                $scope.msgSuccess="订票成功!您的订单编号为:"+data.mid+"。您可以在用户中心查看订单状态";
                $rootScope.phone=$scope.user.phone;
            }else{
                $scope.msgError="订票失败!失败"+data.reason;
            }
        });
    }
});
app.controller('myorderCtrl',function($scope,$http,$rootScope){
    $http.get('data/order_getbyphone.php?phone='+$rootScope.phone).success(function(data){
        console.log(data);
        $scope.movieList=data;
    });
});
app.config(function($routeProvider){
    $routeProvider.when('/start',{
            templateUrl:'tpl/start.html'
        })
        .when('/main',{
            templateUrl:'tpl/main.html',
            controller:'mainCtrl'
        }).when('/detail',{
            templateUrl:'tpl/detail.html',
            controller:'detailCtrl'
        })
        .when('/detail/:mid',{
            templateUrl:'tpl/detail.html',
            controller:'detailCtrl'
        })
        .when('/order',{
            templateUrl:'tpl/order.html',
            controller:'orderCtrl'
        })
        .when('/order/:mid',{
            templateUrl:'tpl/order.html',
            controller:'orderCtrl'
        })
        .when('/myorder',{
            templateUrl:'tpl/myorder.html',
            controller:'myorderCtrl'
        })
        .otherwise({redirectTo:'start'})
});
