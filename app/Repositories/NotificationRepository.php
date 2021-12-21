<?php

namespace App\Repositories;

use App\Models\Notification;

use App\QueryFilters\Isread;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\INotificationRepository;

class NotificationRepository implements INotificationRepository
{

    private $notification;


    public function __construct(Notification $notification) 
    {
        $this->notification = $notification;
    }

    public function getAll()
    {

        return app(Pipeline::class)
        ->send(Notification::query())
        ->through([
            \App\QueryFilters\Isread::class,
        ])
        ->thenReturn()
        ->paginate(3);
    }

    public function querable()
    {
        return $this->model->query();
    }

    public function getById($id)
    {
        return $this->model->findorfail($id);
    }

    public function add(array $attributes)
    {

        $action = $this->notification->create($attributes);
        return $action;
 
    }

    public function update($id, array $data){
        $ten = $this->model->findOrFail($id);
        return $ten->update($data);
    }

    public function delete($id){

        $ten = $this->model->findOrFail($id);

        return $ten->update(['IsActive' => 0]);

    }

}
