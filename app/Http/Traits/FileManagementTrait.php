<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait FileManagementTrait
{

    /**
     * Handle image upload for any model.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $model The model to attach the image to
     * @param string $imageField The name of the image field in the form
     * @param string $folderName The folder to store the image
     * @return void
     */
    public function handleFileUpload(Request $request, $model, $fileField = 'image', $folderName = 'uploads/', $multiple = false)
    {
        // Check if the request has a file
        if ($multiple) {
            if ($request->hasFile($fileField)) {
                $files = $request->file($fileField);
                $filePaths = [];

                foreach ($files as $index => $file) {
                    $fileName = $request->name . '_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs($folderName, $fileName, 'public');
                    $filePaths[] = $path;
                }

                // If the model already has files, delete the old ones
                if ($model->$fileField) {
                    foreach (json_decode($model->$fileField) as $oldFilePath) {
                        $this->fileDelete($oldFilePath);
                    }
                }

                // Assign the new images path as a JSON array to the model
                $model->$fileField = json_encode($filePaths);
            }
        } else {
            if ($request->hasFile($fileField)) {
                $file = $request->file($fileField);
                $fileName = $request->name . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs($folderName, $fileName, 'public');

                // If the model already has an file, delete the old one
                if ($model->$fileField) {
                    $this->fileDelete($model->$fileField);
                }

                // Assign the new image path to the model
                $model->$fileField = $path;
            }
        }
    }
    public function fileDelete($file)
    {
        if ($file) {
            Storage::disk('public')->delete($file);
        }
    }
}
