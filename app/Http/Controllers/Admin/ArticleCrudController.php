<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ArticleRequest as StoreRequest;
use App\Http\Requests\ArticleRequest as UpdateRequest;

class ArticleCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel("App\Models\Article");
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/article');
        $this->crud->setEntityNameStrings('article', 'articles');

        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
        */

        // ------ CRUD COLUMNS
        $this->crud->addColumn([
                                'name' => 'date',
                                'label' => 'Date',
                                'type' => 'date',
                            ]);
        $this->crud->addColumn([
                                'name' => 'status',
                                'label' => 'Status',
                            ]);
        $this->crud->addColumn([
                                'name' => 'title',
                                'label' => 'Title',
                            ]);
        $this->crud->addColumn([
                                'name' => 'featured',
                                'label' => 'Featured',
                                'type' => 'check',
                            ]);
        $this->crud->addColumn([
                                'label' => 'Category',
                                'type' => 'select',
                                'name' => 'category_id',
                                'entity' => 'category',
                                'attribute' => 'name',
                                'model' => "App\Models\Category",
                            ]);

        // ------ CRUD FIELDS
        $this->crud->addField([
                                'name' => 'title',
                                'label' => 'Title',
                                'type' => 'text',
                                'count_down' => 70,
                                'attributes' => ['maxlength' => 70],
                                'placeholder' => 'Your title here',
                            ]);
        $this->crud->addField([
                                'name' => 'slug',
                                'label' => 'Slug (URL)',
                                'type' => 'text',
                                'hint' => 'Будет автоматически сгенерирован из вашего названия, если он оставлен пустым.',
                                // 'disabled' => 'disabled'
                            ]);

        $this->crud->addField([
                                'name' => 'date',
                                'label' => 'Date',
                                'type' => 'date',
                                'value' => date('Y-m-d'),
                            ], 'create');
        $this->crud->addField([
                                'name' => 'date',
                                'label' => 'Date',
                                'type' => 'date',
                            ], 'update');

        $this->crud->addField([
                                'name' => 'content',
                                'label' => 'Content',
                                'type' => 'ckeditor',
                                'extra_plugins' => ['oembed', 'widget', 'justify', 'btgrid'],
                            ]);
        $this->crud->addField([
                                'name' => 'image',
                                'label' => 'Image',
                                'type' => 'browse',
                            ]);
        $this->crud->addField([
                                'label' => 'Category',
                                'type' => 'select2',
                                'name' => 'category_id',
                                'entity' => 'category',
                                'attribute' => 'name',
                                'model' => "App\Models\Category",
                            ]);
        $this->crud->addField([
                                'label' => 'Tags',
                                'type' => 'select2_multiple',
                                'name' => 'tags', // the method that defines the relationship in your Model
                                'entity' => 'tags', // the method that defines the relationship in your Model
                                'attribute' => 'name', // foreign key attribute that is shown to user
                                'model' => "App\Models\Tag", // foreign key model
                                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                            ]);
        $this->crud->addField([
                                'name' => 'status',
                                'label' => 'Status',
                                'type' => 'enum',
                            ]);
        $this->crud->addField([
                                'name' => 'featured',
                                'label' => 'Featured item',
                                'type' => 'checkbox',
                            ]);

        $this->crud->enableAjaxTable();

        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']);
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though: 
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable(); 

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
}
