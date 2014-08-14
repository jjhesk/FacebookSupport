<?php
/**
 * LikeGate is used to determine if user is fan of Facebook Page or not which allow to make
 * different page content depending on fan status.
 */
class LikeGate {
  public function IsUserFan()
  { 
    if (isset($_REQUEST["signed_request"])) {
        $signedRequest = $_REQUEST["signed_request"];
        list($encodedSig, $payload) = explode('.', $signedRequest, 2);
        $data = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);
        $page = $data["page"];
        if ($page["liked"]) {
            return true;
        }
    }
    return false;
  }
}

?>
