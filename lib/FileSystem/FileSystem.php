<?php

interface IFileSystem
{
	/**
	 * @abstract
	 * @param $path string
	 * @param $fileName string
	 * @param $fileContents string
	 * @return void
	 */
	public function Add($path, $fileName, $fileContents);

	/**
	 * @abstract
	 * @param $fullPath string
	 * @return string
	 */
	public function GetFileContents($fullPath);

	/**
	 * @abstract
	 * @param $fullPath string
	 * @return void
	 */
	public function RemoveFile($fullPath);
}

class FileSystem implements IFileSystem
{
	public function Add($path, $fileName, $fileContents)
	{
		$fullName = $path. $fileName;
		Log::Debug('Saving file to $s',$fullName );

		if (file_put_contents($fullName, $fileContents) === false)
		{
			Log::Error('Could not write contents of file: %s', $fullName);
		}
	}

	/**
	 * @param $fullPath string
	 * @return string
	 */
	public function GetFileContents($fullPath)
	{
		$contents = file_get_contents($fullPath);
		if ($contents === false)
		{
			Log::Error('Could not read contents of file: %s', $fullPath);
			return null;
		}

		return $contents;
	}

	/**
	 * @param $fullPath string
	 * @return void
	 */
	public function RemoveFile($fullPath)
	{
		Log::Debug('Deleting file: %s', $fullPath);
		if (unlink($fullPath) === false)
		{
			Log::Error('Could not delete file: %s', $fullPath);
		}
	}
}
?>