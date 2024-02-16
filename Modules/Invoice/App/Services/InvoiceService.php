<?php

namespace Modules\Invoice\app\Services;

use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Modules\Invoice\app\Repositories\InvoiceRepository;
use Modules\User\app\DTOs\UserDTO;
use Modules\User\App\resources\AllUserResource;
use Modules\User\app\Resources\AuthResource;
use Modules\User\App\resources\UserResource;

class InvoiceService {

    protected $repository;

    public function __construct(InvoiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function list() {

        $invoices = $this->repository->GetAllInvoices();

        $current_page = $this->repository->dtoArray['pagination'];

        $total_invoices = (int)$this->repository->getInvoicesCount()[0]->FilteredCount;

        $pagination_info = [
            'current_page' => $current_page,
                'total' => $total_invoices,
                'last_page' => (int)($total_invoices/20),
                'next_page' => $current_page + 1,
                'prev_page' => $current_page - 1,
        ];

        if($pagination_info['current_page'] ==  $pagination_info['last_page']) 
            $pagination_info['next_page'] = null;

        if($pagination_info['current_page'] ==  0)
            $pagination_info['prev_page'] = null;

        if($pagination_info['current_page'] < 0 || $pagination_info['current_page'] > $pagination_info['last_page']){
            return ApiResponse::apiSendResponse(
                404,
                'Not Found',
            );

        }

        return ApiResponse::apiSendResponse(
            200,
            __('messages.retrieved'),
            ['invoices' => $invoices, 'pagination' => $pagination_info]
        );
    }
}