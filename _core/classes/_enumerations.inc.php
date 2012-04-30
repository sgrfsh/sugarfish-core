<?php
/**
 * File: _enumerations.inc.php
 * Created on: Thu Nov 20 02:04 CST 2008
 *
 * @author Ian
 *
 * @copyright  2008 Ian Atkin
 * @license    http://www.ianatkin.info/
 */

/**
 * @package sugarfish_core
 * @name Exceptions
 * 
 * Custom Exceptions
 */
abstract class Exceptions {
	const ERROR = 9999;

	// general exceptions
	const MULTIPLE_MYSQL_CONNECTION = 5000;
	const STATIC_CLASS_INSTANTIATION = 5001;
	const MULTIPLE_SINGLETON_INSTANTIATION = 5002;
	const INVALID_INSTANTIATION_ATTEMPT = 5003;
	const SESSION_START = 5004;
	const MULTIPLE_SESSION_START = 5005;

	const DATABASE_CONNECTION_ERROR = 5100;

	// page/template exceptions
	const TEMPLATE_NOT_FOUND = 6000;
	const PAGE_ID_NOT_SET = 6001;

	// form exceptions
	const NULL_FORM_ID = 6010;
	const DUPLICATE_CONTROL = 6011;

	// control exceptions
	const NULL_PARENT_OBJECT = 6020;
	const NULL_CONTROL_ID = 6021;
	const NON_ALPHANUMERIC_CONTROL_ID = 6022;
	const ILLEGAL_CONTROL_ID = 6023;
	const CONTROL_EXISTS = 6024;
	const INVALID_CONTROL_PARENT_OBJECT = 6025;
}

abstract class HttpResponse {
	const CONT = 'HTTP/1.0 100 Continue';
	const SWITCHING_PROTOCOLS = 'HTTP/1.0 101 Switching Protocols';
	const OK = 'HTTP/1.0 200 OK';
	const CREATED = 'HTTP/1.0 201 Created';
	const ACCEPTED = 'HTTP/1.0 202 Accepted';
	const NON_AUTHORATIVE_INFORMATION = 'HTTP/1.0 203 Non-Authoritative Information';
	const NO_CONTENT = 'HTTP/1.0 204 No Content';
	const RESET_CONTENT = 'HTTP/1.0 205 Reset Content';
	const PARTIAL_CONTENT = 'HTTP/1.0 206 Partial Content';
	const MULTIPLE_CHOICES = 'HTTP/1.0 300 Multiple Choices';
	const MOVED_PERMANENTLY = 'HTTP/1.0 301 Moved Permanently';
	const FOUND = 'HTTP/1.0 302 Found';
	const SEE_OTHER = 'HTTP/1.0 303 See Other';
	const NOT_MODIFIED = 'HTTP/1.0 304 Not Modified';
	const USE_PROXY = 'HTTP/1.0 305 Use Proxy';
	const UNUSED = 'HTTP/1.0 306 (Unused)';
	const TEMPORARY_REDIRECT = 'HTTP/1.0 307 Temporary Redirect';
	const BAD_REQUEST = 'HTTP/1.0 400 Bad Request';
	const UNAUTHORIZED = 'HTTP/1.0 401 Unauthorized';
	const PAYMENT_REQUIRED = 'HTTP/1.0 402 Payment Required';
	const FORBIDDEN = 'HTTP/1.0 403 Forbidden';
	const NOT_FOUND = 'HTTP/1.0 404 Not Found';
	const METHOD_NOT_ALLOWED = 'HTTP/1.0 405 Method Not Allowed';
	const NOT_ACCEPTABLE = 'HTTP/1.0 406 Not Acceptable';
	const PROXY_AUTHENTICATION_REQUIRED = 'HTTP/1.0 407 Proxy Authentication Required';
	const REQUEST_TEMPLATE = 'HTTP/1.0 408 Request Timeout';
	const CONFLICT = 'HTTP/1.0 409 Conflict';
	const GONE = 'HTTP/1.0 410 Gone';
	const LENGTH_REQUIRED = 'HTTP/1.0 411 Length Required';
	const PRECONDITION_FAILED = 'HTTP/1.0 412 Precondition Failed';
	const ENTITY_TOO_LARGE = 'HTTP/1.0 413 Request Entity Too Large';
	const REQUEST_URI_TOO_LONG = 'HTTP/1.0 414 Request-URI Too Long';
	const UNSUPPORTED_MEDIA_TYPE = 'HTTP/1.0 415 Unsupported Media Type';
	const REQUESTED_RANGE_NOT_SATISFIABLE = 'HTTP/1.0 416 Requested Range Not Satisfiable';
	const EXPECTATION_FAILED = 'HTTP/1.0 417 Expectation Failed';
	const INTERNAL_SERVER_ERROR = 'HTTP/1.0 500 Internal Server Error';
	const NOT_IMPLEMENTED = 'HTTP/1.0 501 Not Implemented';
	const BAD_GATEWAY = 'HTTP/1.0 502 Bad Gateway';
	const SERVICE_UNAVAILABLE = 'HTTP/1.0 503 Service Unavailable';
	const GATEWAY_TIMEOUT = 'HTTP/1.0 504 Gateway Timeout';
	const HTTP_VERSION_NOT_SUPPORTED = 'HTTP/1.0 505 HTTP Version Not Supported';
}

/**
 * @package sugarfish_core
 * @name Layout
 * Website Layout constants
 */
abstract class Layout {
	const NotSet = 'NotSet';
	const Plain = 'Plain';
}

/**
 * @package sugarfish_core
 * @name WebsiteQSTags
 * Website Query String tag constants
 */
abstract class WebsiteQSTags {
    const EXAMPLE = 'example'; // query string example
}

/**
 * @package sugarfish_core
 * @name DateFormats
 * 
 * Date Formats
 * DATE_ATOM  	Atom (example: 2005-08-15T16:13:03+0000)
 * DATE_COOKIE 	HTTP Cookies (example: Sun, 14 Aug 2005 16:13:03 UTC)
 * DATE_ISO8601 	ISO-8601 (example: 2005-08-14T16:13:03+0000)
 * DATE_RFC822 	RFC 822 (example: Sun, 14 Aug 2005 16:13:03 UTC)
 * DATE_RFC850 	RFC 850 (example: Sunday, 14-Aug-05 16:13:03 UTC)
 * DATE_RFC1036 	RFC 1036 (example: Sunday, 14-Aug-05 16:13:03 UTC)
 * DATE_RFC1123 	RFC 1123 (example: Sun, 14 Aug 2005 16:13:03 UTC)
 * DATE_RFC2822 	RFC 2822 (Sun, 14 Aug 2005 16:13:03 +0000)
 * DATE_RSS 	RSS (Sun, 14 Aug 2005 16:13:03 UTC)
 * DATE_W3C 	World Wide Web Consortium (example: 2005-08-14T16:13:03+0000)
 */
abstract class DateFormats {
	const COMPACT = "n-j-Y";
	const DATETIME = "Y-m-d H:i:s";
	const RFC2822 = DATE_RFC2822;
	const COMPACT_DISPLAY = "M j g:i A";
	const BLOG = "M j, Y";
	const DATE_FULL = "F j, Y";
	const DATE_MONTH_YEAR = "F, Y";
}

/**
 * @package sugarfish_core
 * @name SecondsIn
 */
abstract class SecondsIn {
	const YEAR = 3155692;
	const MONTH = 2592000;
	const DAY = 86400;
	const HOUR = 3600;
	const MINUTE = 60;
}
?>
