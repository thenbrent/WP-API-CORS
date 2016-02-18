WP REST API CORS
=====

Enable [CORS][] for the [WP REST API][wp-api] (and the [REST API infrastructure now in WordPress core][wp]. Acronym all the things.

**Warning:** Experimental. It is not recommended you use this on live sites without understanding the implications of allowing access to your site from *any* host. If you wish to restrict the hosts that can perform CORS requests, the [`Access-Control-Allow-Origin`](https://github.com/thenbrent/WP-API-CORS/blob/master/wp-api-cors.php#L72) can be modified to your requirements.

[CORS]: http://www.html5rocks.com/en/tutorials/cors/
[wp-api]: https://github.com/WP-API/WP-API
[wp]: https://make.wordpress.org/core/2015/10/28/rest-api-welcome-the-infrastructure-to-core/
