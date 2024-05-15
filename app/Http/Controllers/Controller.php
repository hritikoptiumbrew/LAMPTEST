<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      x={
 *          "logo": {
 *              "url": "https://via.placeholder.com/190x90.png?text=L5-Swagger"
 *          }
 *      },
 *      title="ob_bg_removal",
 *      description="L5 Swagger ob_testimonial OpenApi description",
 *      @OA\SecurityScheme(
 *          securityScheme="bearerAuth",
 *          in="header",
 *          name="bearerAuth",
 *          description="Authentication Bearer Token",
 *          type="http",
 *          scheme="bearer",
 *          bearerFormat="JWT",
 *      ),
 *      @OA\Contact(
 *          email="info@optimumbrew.com"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
