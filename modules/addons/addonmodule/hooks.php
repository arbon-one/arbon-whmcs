<?php

add_hook('AddonActivation', 1, function(array $vars) {
    try {
        $curl = curl_init();

        $base = $vars['is_production'] == true ? 'api.arbon.one' : 'dev-api.arbon.one';

        $url = 'https://' . $base . '/v1/offset?access_token=' . ACCESS_TOKEN . '&amount=' . urlencode('amount') . '&reason=' . urlencode('reason');

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    } catch (Exception $e) {
        // Consider logging or reporting the error.
    }
});
