<?php

use Illuminate\Support\Facades\Route;
use ebeauchamps\MultiTaxonomies\Http\Controllers\MultiTaxonomiesController;

Route::prefix('ebeauchamps/multitaxonomies')->name('ebeauchamps.multitaxonomies.')->group(function () {
    Route::post('/getFirstSelectItems', [MultiTaxonomiesController::class, 'getFirstSelectItems'])->name('getFirstSelectItems');
});
