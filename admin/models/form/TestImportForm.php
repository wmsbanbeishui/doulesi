<?php

namespace admin\models\form;

use common\helpers\Message;
use common\models\base\ImportBase;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\base\Model;
use yii\web\UploadedFile;

class TestImportForm extends Model
{
	public $file;

	public function rules()
	{
		return [
			['file', 'required'],
			['file', 'file',
				'extensions' => ['xls', 'xlsx', 'cvs'],
				'checkExtensionByMimeType' => false,
			]
		];
	}

	public function attributeLabels()
	{
		return ['file' => '文件'];
	}

	public function import()
	{
		$this->file = UploadedFile::getInstance($this, 'file');

		if (!$this->validate()) {
			return false;
		}

		$spreadsheet = IOFactory::load($this->file->tempName);
		$sheetData = $spreadsheet->getActiveSheet()->toArray(); // null, true, true, true

		unset($sheetData[0]);

		if (empty($sheetData)) {
			$this->addError('file', '至少导入一条数据');
			return false;
		}

		$lastAssign = [];
		$messages = [];
		$date = [];
		$successCount = 0;

		foreach ($sheetData as $n => $row) {
			$hasError = false;
			$msg = '第'.($n + 1).'行';

			$name = $row[0];

			if (!$name) {
				$msg .= '，姓名不能为空';
				$hasError = true;
			}

			if ($hasError) {
				$messages[] = $msg;
				continue;
			}

			$import = new ImportBase([
				'name' => $name,
			]);

			if ($import->save(false)) {
				$successCount++;
			} else {
				$msg .= '，保存失败';
				$hasError = true;
			}

			if ($hasError) {
				$messages[] = $msg;
				continue;
			}
		}

		if ($successCount) {
			Message::setSuccessMsg('导入了'.$successCount.'个客户');
		}

		if ($messages) {
			Message::setErrorMsg($messages);
			return false;
		}

		return true;
	}
}
