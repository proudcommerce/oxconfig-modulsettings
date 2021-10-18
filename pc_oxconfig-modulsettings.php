<?php
/**
 * @package oxconfig-modulesettings
 * @version 1.1.0
 * @url     https://github.com/proudcommerce/oxconfig-modulsettings
 *
 * @author  Stefan Moises <beffy@proudcommerce.com>
 * @author  Tobias Merkl <tobias@proudcommerce.com>
 */

require_once dirname(__FILE__) . "/bootstrap.php";

use OxidEsales\Eshop\Core\Registry;

// CHANGE THIS!!!
$secretKey = 'adc92rwsfvjsdfkSS093tergAskdfs';
$msg = "";

function resetModule($sModuleId, $search = '')
{
    $ret = "<p>Resetting module: $sModuleId</p>";
    $oConfig = Registry::getConfig();
    $aModules = $oConfig->getShopConfVar('aModules');
    // there may be old module chain keys inside the array!
    if ($search !== '') {
        foreach ($aModules as $k => $v) {
            if (strpos($v, $search) !== false) {
                $ret .= "<br>Removing '$search' from entry $k with value $v!";
                $v = str_replace($search, '', $v);
                $aModules[$k] = $v;
            }
        }
        $oConfig->saveShopConfVar('aarr', 'aModules', $aModules);
    }
    if ($sModuleId == '') {
        return;
    }

    $iOldKey = array_search($sModuleId, $aModules);
    if ($iOldKey !== false) {
        unset($aModules[$iOldKey]);
        $oConfig->saveShopConfVar('aarr', 'aModules', $aModules);
        $ret .= "<br/>[INFO] Module {$sModuleId} removed from aModules";
    }

    // check disabled modules
    $aDisabledModules = $oConfig->getShopConfVar('aDisabledModules');
    $iOldKey = array_search($sModuleId, $aDisabledModules);
    if ($iOldKey !== false) {
        unset($aDisabledModules[$iOldKey]);
        $oConfig->saveShopConfVar('aarr', 'aDisabledModules', $aDisabledModules);
        $ret .= "<br/>[INFO] Module {$sModuleId} removed from aDisabledModules";
    }
    $aModulePaths = $oConfig->getShopConfVar('aModulePaths');
    if (array_key_exists($sModuleId, $aModulePaths)) {
        unset($aModulePaths[$sModuleId]);
        $oConfig->saveShopConfVar('aarr', 'aModulePaths', $aModulePaths);
        $ret .= "<br/>[INFO] Module {$sModuleId} removed from aModulePaths";
    }
    $aModuleFiles = $oConfig->getShopConfVar('aModuleFiles');
    if (array_key_exists($sModuleId, $aModuleFiles)) {
        unset($aModuleFiles[$sModuleId]);
        $oConfig->saveShopConfVar('aarr', 'aModuleFiles', $aModuleFiles);
        $ret .= "<br/>[INFO] Module {$sModuleId} removed from aModuleFiles";
    }
    $aModuleTemplates = $oConfig->getShopConfVar('aModuleTemplates');
    if (array_key_exists($sModuleId, $aModuleTemplates)) {
        unset($aModuleTemplates[$sModuleId]);
        $oConfig->saveShopConfVar('aarr', 'aModuleTemplates', $aModuleTemplates);
        $ret .= "<br/>[INFO] Module {$sModuleId} removed from aModuleTemplates";
    }
    $aModuleControllers = $oConfig->getShopConfVar('aModuleControllers');
    if (array_key_exists($sModuleId, $aModuleControllers)) {
        unset($aModuleControllers[$sModuleId]);
        $oConfig->saveShopConfVar('aarr', 'aModuleControllers', $aModuleControllers);
        $ret .= "<br/>[INFO] Module {$sModuleId} removed from aModuleControllers";
    }
    $aModuleEvents = $oConfig->getShopConfVar('aModuleEvents');
    if (array_key_exists($sModuleId, $aModuleEvents)) {
        unset($aModuleEvents[$sModuleId]);
        $oConfig->saveShopConfVar('aarr', 'aModuleEvents', $aModuleEvents);
        $ret .= "<br/>[INFO] Module {$sModuleId} removed from aModuleEvents";
    }
    $aModuleVersions = $oConfig->getShopConfVar('aModuleVersions');
    if (array_key_exists($sModuleId, $aModuleVersions)) {
        unset($aModuleVersions[$sModuleId]);
        $oConfig->saveShopConfVar('aarr', 'aModuleVersions', $aModuleVersions);
        $ret .= "<br/>[INFO] Module {$sModuleId} removed from aModuleVersions";
    }
    $ret .= "<p>Done resetting!</p>";
    return $ret;
}

$encoded = trim($_POST['encvalue']);
$decoded = trim($_POST['decvalue']);
$secret = trim($_POST['secret']);
$moduleId = trim($_POST['moduleid']);
$toreplace = trim($_POST['toreplace']);
$secretOK = ($secret !== '' && $secret === $secretKey);

$oConfig = Registry::getConfig();
$sModules = $sDisabledModules = $sModuleEvents = $sModuleFiles = $sModuleVersions = $sModuleTemplates = $sModuleControllers = '';

$aModules = $oConfig->getShopConfVar('aModules');
$aDisabledModules = $oConfig->getShopConfVar('aDisabledModules');
$aModuleEvents = $oConfig->getShopConfVar('aModuleEvents');
$aModuleFiles = $oConfig->getShopConfVar('aModuleFiles');
$aModuleVersions = $oConfig->getShopConfVar('aModuleVersions');
$aModuleTemplates = $oConfig->getShopConfVar('aModuleTemplates');
$aModuleControllers = $oConfig->getShopConfVar('aModuleControllers');

if ($encoded !== '' && $decoded === '') {
    $decoded = var_export(unserialize($encoded), true);
} elseif ($encoded === '' && $decoded !== '') {
    $encoded = serialize($decoded);
} else {
    if ($secretOK) {
        $sModules = var_export($aModules, true);
        $sDisabledModules = var_export($aDisabledModules, true);
        $sModuleEvents = var_export($aModuleEvents, true);
        $sModuleFiles = var_export($aModuleFiles, true);
        $sModuleVersions = var_export($aModuleVersions, true);
        $sModuleTemplates = var_export($aModuleTemplates, true);
        $sModuleControllers = var_export($aModuleControllers, true);
    }
}

if ($secretOK) {
    if ($moduleId !== '' || $toreplace !== '') {
        $msg .= resetModule($moduleId, $toreplace);
    }
} else {
    $msg = "<p><b>No / wrong secret, sorry!</b></p>";
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ProudCommerce oxConfig Modulsettings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  </head>
  <body>
  <section class="section">
    <div class="container">
        <h1 class="title">ProudCommerce oxConfig Modulsettings</h1>
        <?php
        if ($msg !== '') {
        ?>
        <div class="notification">
            <?php echo $msg; ?>
        </div>
        <?php
        }
        ?>
        <form name="encdec" action="pc_oxconfig-modulsettings.php" method="POST">
        	<h2 class="subtitle">Enter secret to submit!</h2>
            <input class="input" type="password" size="30" name="secret" value="<?php echo $secret; ?>" size="30"/>
            <br><br>
            <h2 class="subtitle">Reset module by ID (module will be removed from aModules, aModuleEvents, aModuleFiles, aDisabledModules, aModuleVersions, aModuleTemplates, aModuleControllers)</h2>
            <input class="input" type="text" placeholder="exonn_sengines" name="moduleid" value="<?php echo $moduleId; ?>" size="30"/>
            <br>
            <br>
            <h2 class="subtitle">Remove this value from aModules values</h2>
            <input class="input" type="text" size="100" placeholder="&exonn_sengines/core/exonn_google_oxarticle" name="toreplace" value="<?php echo $toreplace; ?>" size="30"/>
            <br><br>
            <input class="button is-primary" type="submit" value="Go!"/>
            <br/><br><br>
            <h2 class="subtitle">Unserialized aModules value (display only)</h2>
            <textarea class="textarea" name="decvalue" rows="6" cols="100" disabled="disabled"><?php echo $sModules;?></textarea>
            <br>
            <h2 class="subtitle">Unserialized aDisabledModules value (display only)</h2>
            <textarea class="textarea" name="decvalue" rows="6" cols="100" disabled="disabled"><?php echo $sDisabledModules;?></textarea>
            <br>
            <h2 class="subtitle">Unserialized aModuleEvents value (display only)</h2>
            <textarea class="textarea" name="decvalue" rows="6" cols="100" disabled="disabled"><?php echo $sModuleEvents;?></textarea>
            <br>
            <h2 class="subtitle">Unserialized aModuleFiles value (display only)</h2>
            <textarea class="textarea" name="decvalue" rows="6" cols="100" disabled="disabled"><?php echo $sModuleFiles;?></textarea>
            <br>
            <h2 class="subtitle">Unserialized aModuleVersions value (display only)</h2>
            <textarea class="textarea" name="decvalue" rows="6" cols="100" disabled="disabled"><?php echo $sModuleVersions;?></textarea>
            <br>
            <h2 class="subtitle">Unserialized aModuleTemplates value (display only)</h2>
            <textarea class="textarea" name="decvalue" rows="6" cols="100" disabled="disabled"><?php echo $sModuleTemplates;?></textarea>
            <br>
            <h2 class="subtitle">Unserialized aModuleControllers value (display only)</h2>
            <textarea class="textarea" name="decvalue" rows="6" cols="100" disabled="disabled"><?php echo $sModuleControllers;?></textarea>
            </form>
        </div>
    </body>
</html>
