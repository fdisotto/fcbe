<?php


/************************************************************
 * RSS Fetch 0.4.3 (23 July 2005)
 * RSS Feed Reader
 * Author: Drew Phillips
 ************************************************************/
class rss_parser
{
    var $update_interval = 60;
    /* How often to fetch the rss file
       A cached version will be used between updates    */

    var $data_directory = "./dati/cache";
    /* Where to store the rss data from the feeds
       Note: an absolute path is better than a relative path here
       unless you plan on keeping the script to display the feeds
       in the same folder as this file and the feeds.   */

    /* NO NEED TO EDIT BELOW HERE UNLESS YOU KNOW WHAT YOU ARE DOING  */

    var $rss_url;
    var $num_to_show;
    var $offset;  //added in version 0.4.3
    var $do_update;
    var $tags = array();
    var $content;
    var $rss  = array();
    var $feed_title;
    var $feed_link;
    var $feed_description;
    var $my_html;

    function __construct( $url, $numtoshow = 10, $html = "", $update = false, $offset = 1 )
    {
        $this->rss_url = $url;
        $this->num_to_show = $numtoshow;
        $this->do_update = $update;
        $this->my_html = preg_replace( "/(#{.*?):(.*?})/", "\\1__\\2", $html ); //xx:xx tag workaround
        $this->offset = --$offset;

        $this->content = $this->fetch_feed();
        $this->parse_feed();
        $this->show();
    }

    /* string */
    function fetch_feed()
    {
        $url_parts = parse_url( $this->rss_url );

        $filename = $url_parts[ 'host' ] . str_replace( "/", ",", $url_parts[ 'path' ] ) . "_" . @$url_parts[ 'query' ];
        if ( file_exists( $this->data_directory . "/$filename" ) ) {
            $last = filemtime( $this->data_directory . "/$filename" );
            $create = 0;
            if ( time() - $last > $this->update_interval * 60 || $this->update_interval == 0 ) {
                $update = 1;
            } else {
                $update = 0;
            }
        } else {
            $create = 1;
            $update = 1;
        }

        if ( $create == 1 || ( $this->do_update == true && $update == 1 ) ) {
            $fp = @fsockopen( $url_parts[ 'host' ], 80, $errno, $errstr, 5 );
            if ( ! $fp ) {
                echo "Feed RSS non raggiungibile {$this->feed_url} in {$_SERVER['PHP_SELF']}<br />\n";

                return;
            }

            fputs( $fp, "GET " . $url_parts[ 'path' ] . "" . @$url_parts[ 'query' ] . " HTTP/1.0\r\n" . "Host: " . $url_parts[ 'host' ] . "\r\n" . "User-Agent: FCBE's RSS Reader 0.1\r\n" . "Connessione: Chiusa\r\n\r\n" );

            $rss_data = '';
            while ( ! feof( $fp ) ) {
                $rss_data .= @fgets( $fp, 1024 );
            }

            list( , $rss_data ) = explode( "\r\n\r\n", $rss_data, 2 );

            $output = @fopen( $this->data_directory . "/$filename", "w+" );
            if ( ! $output ) {
                return $rss_data;
            } else {
                flock( $output, LOCK_EX );
                fputs( $output, $rss_data );
                flock( $output, LOCK_UN );
                fclose( $output );
            }
        } //update

        return file_get_contents( $this->data_directory . "/$filename" );
    }

    /* void */
    function parse_feed()
    {
        preg_match( "/<title>(.*?)<\/title>/", $this->content, $title );
        $this->feed_title = @$title[ 1 ];

        preg_match( "/<link>(.*?)<\/link>/", $this->content, $link );
        $this->feed_link = @$link[ 1 ];

        preg_match( "/<description>(.*?)<\/description>/", $this->content, $description );
        $this->feed_description = @$description[ 1 ];

        preg_match_all( "/<item[^>]*>(.*?)<\/item>/s", $this->content, $items );
        if ( count( $items[ 0 ] ) == 0 ) {
            echo "Nessun elemento presente nel feed rss.<br />\n";
        }

        for ( $i = 0; $i < count( $items[ 0 ] ); ++$i ) {
            preg_match_all( "/(?:<([\w:]*)[^>]*>\s*(?:<!\[CDATA\[)?(.*?)(?:]]>)?\s*<\/\\1>)+?/si", preg_replace( "/<item[^>]*>/", "", $items[ 0 ][ $i ] ), $elements );
            for ( $j = 0; $j < count( $elements[ 0 ] ); ++$j ) {
                $elements[ 1 ][ $j ] = str_replace( ":", "__", $elements[ 1 ][ $j ] );  //regex fix for items with : like dc:date
                $this->rss[ $i ][ $elements[ 1 ][ $j ] ] = trim( html_entity_decode( $elements[ 2 ][ $j ] ) );
            }
        }
    }

    /* void */
    function show()
    {
        if ( $this->my_html == "" ) {
            $this->show_html();
        } else {
            $this->show_user_html();
        }
    }

    function show_html()
    {
        $show = ( count( $this->rss ) > $this->num_to_show ? $this->num_to_show : count( $this->rss ) );
        for ( $i = $this->offset; $i < $this->offset + $show; ++$i ) {
            echo "- <a href=\"{$this->rss[$i]['link']}\" target=\"_blank\">{$this->rss[$i]['title']}</a><br />\n";
        }
    }

    function show_user_html()
    {
        $show = ( count( $this->rss ) > $this->num_to_show + $this->offset ? $this->num_to_show : count( $this->rss ) );
        $show = ( $this->offset + $this->num_to_show > count( $this->rss ) ? count( $this->rss ) - $this->offset : $this->num_to_show );
        for ( $i = $this->offset; $i < $this->offset + $show; ++$i ) {
            extract( $this->rss[ $i ] );
            $item = preg_replace( "/#\{([^}]+)}/e", "$\\1", $this->my_html );
            echo $item;
        }
    }

} // end class
?>
