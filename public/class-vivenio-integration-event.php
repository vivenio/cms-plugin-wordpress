<?php

class VivenioIntegrationEvent
{
    /**
     * Start up
     */
    public function __construct()
    {
        add_shortcode('vivenio-event', array($this, 'vivenio_event_shortcode'));
    }

    public function vivenio_event_shortcode($atts, $content = null, $code = '')
    {
        if (is_feed()) {
            return '[vivenio-event]';
        }

        if ('vivenio-event' == $code) {
            $atts = shortcode_atts(
                array(
                    'event' => '',
                    'forward' => 'false',
                ),
                $atts,
                'vivenio-event'
            );

            $event = (string)$atts['event'];
            $forward = (bool)$atts['forward'] === 'true';
            $options = get_option('vivenio_option_name');

            return $this->getVivenioFrontoffice($options['eventBaseUrl'], $event, $forward);
        }

        return '[vivenio-event 404 "Not Found"]';
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/seamless.parent.js', array(), $this->version, false);
    }

    public function getVivenioFrontoffice($url, $eventParameter, $forward = false)
    {
        if (!$url || !$eventParameter) {
            return false;
        }

        $template = <<<EOF
        <script type="text/javascript">
            var url = '{{url}}';
            var eventParameter = '{{eventParameter}}';
            var forward = '{{forward}}';

            window.onload = function () {
                var queryParams = window.location.search ? window.location.search.substr(1) : '';
                var iframe = document.createElement('iframe');
                iframe.setAttribute('src', url + '/#/?event=' + eventParameter + '&iframe=true' + (forward ? '&forward=true' : '') + (queryParams ? '&' + queryParams : ''));
                iframe.setAttribute('id', 'vivenio-iframe');
                iframe.setAttribute('frameborder', '0');
                iframe.setAttribute('seamless', '');
                document.getElementById('vivenio').appendChild(iframe);

                var vivenioIframe = document.getElementById('vivenio-iframe');
                window.seamless(vivenioIframe);
    
                if (queryParams.match(/vjump\=true/g)) {
                    vivenioIframe.scrollIntoView(true);
                    setTimeout(function() {
                        vivenioIframe.scrollIntoView(true);
                    }, 800);
                }
            };
        </script>
        <div id="vivenio"></div>
EOF;

        $template = str_replace('{{url}}', $url, $template);
        $template = str_replace('{{eventParameter}}', $eventParameter, $template);
        $template = str_replace('{{forward}}', $forward, $template);

        return $template;
    }
}

$vivenio_integration_event = new VivenioIntegrationEvent();
