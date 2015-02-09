<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * File manipulation utility class.
 */
class ongr_sync_oxUtilsFile extends ongr_sync_oxUtilsFile_parent
{
    /**
     * Uploaded file processor (filters, etc), sets configuration parameters to  passed object and returns it.
     *
     * @param object $oObject          Object, that parameters are modified according to passed files.
     * @param array  $aFiles           Name of files to process.
     * @param bool   $blUseMasterImage Use master image as source for processing.
     * @param bool   $blUnique         TRUE - forces new file creation with unique name.
     *
     * @return object
     */
    public function processFiles($oObject = null, $aFiles = array(), $blUseMasterImage = false, $blUnique = true)
    {
        $aFiles = $aFiles ? $aFiles : $_FILES;
        if (isset($aFiles['myfile']['name'])) {
            $oDb = oxDb::getDb();

            $oConfig = $this->getConfig();
            $oStr = getStr();

            // A. protection for demoshops - strictly defining allowed file extensions.
            $blDemo = (bool)$oConfig->isDemoShop();

            // Folder where images will be processed.
            $sTmpFolder = $oConfig->getConfigParam('sCompileDir');

            $iNewFilesCounter = 0;
            $aSource = $aFiles['myfile']['tmp_name'];
            $aError = $aFiles['myfile']['error'];
            $sErrorsDescription = '';

            $oEx = oxNew('oxExceptionToDisplay');
            while (list($sKey, $sValue) = each($aFiles['myfile']['name'])) {
                $sSource = $aSource[$sKey];
                $iError = $aError[$sKey];
                $aFiletype = explode('@', $sKey);
                $sKey = $aFiletype[1];
                $sType = $aFiletype[0];

                $sValue = strtolower($sValue);
                $sImagePath = $this->_getImagePath($sType);

                // Should translate error to user if file was uploaded.
                if (UPLOAD_ERR_OK !== $iError && UPLOAD_ERR_NO_FILE !== $iError) {
                    $sErrorsDescription = $this->translateError($iError);
                    $oEx->setMessage($sErrorsDescription);
                    oxRegistry::get('oxUtilsView')->addErrorToDisplay($oEx, false);
                }

                // Checking file type and building final file name.
                if ($sSource && ($sValue = $this->_prepareImageName(
                    $sValue,
                    $sType,
                    $blDemo,
                    $sImagePath,
                    $blUnique
                ))
                ) {
                    // Moving to tmp folder for processing as safe mode or spec. open_basedir setup.
                    // Usually does not allow file modification in php's temp folder.
                    $sProcessPath = $sTmpFolder . basename($sSource);

                    if ($sProcessPath) {
                        if ($blUseMasterImage) {
                            // Using master image as source, so only copying it to.
                            $blMoved = $this->_copyFile($sSource, $sImagePath . $sValue);
                        } else {
                            $blMoved = $this->_moveImage($sSource, $sImagePath . $sValue);
                        }

                        if ($blMoved) {
                            // New image successfully add.
                            $iNewFilesCounter++;
                            // Assign the name.
                            if ($oObject && isset($oObject->$sKey)) {
                                $oObject->{$sKey}->setValue($sValue);
                                $oDb->Execute(
                                    "INSERT INTO `ongr_sync_jobs` SET
                                            `TYPE` = 'U',
                                            `WORKER_TYPE` = 'P',
                                            `ENTITY` = 'pictures',
                                            `TABLE` = ?,
                                            `OXID` = ?,
                                            `STATUS` = 0,
                                            `PRIORITY` = 0,
                                            `CHANGES` = ?",
                                    array(
                                        $oObject->getCoreTableName(),
                                        $oObject->getId(),
                                        $sKey
                                    )
                                );
                            }
                        }
                    }
                }
            }

            $this->_setNewFilesCounter($iNewFilesCounter);
        }

        return $oObject;
    }
}
