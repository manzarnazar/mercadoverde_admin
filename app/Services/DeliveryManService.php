<?php

namespace App\Services;
use App\CentralLogics\Helpers;
use App\Traits\FileManagerTrait;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Cast\Object_;

class DeliveryManService
{
    use FileManagerTrait;

    public function getAddData(Object $request): array
    {
        if ($request->has('image')) {
            $imageName = $this->upload('delivery-man/', 'png', $request->file('image'));
        } else {
            $imageName = 'def.png';
        }

        $identityImageNames = [];
        if (!empty($request->file('identity_image'))) {
            foreach ($request->identity_image as $img) {
                $identityImage = $this->upload('delivery-man/', 'png', $img);
                array_push($identityImageNames, ['img'=>$identityImage, 'storage'=> Helpers::getDisk()]);
            }
            $identityImage = json_encode($identityImageNames);
        } else {
            $identityImage = json_encode([]);
        }

        $driverLicenseImage = null;
        if ($request->has('driver_license_image')) {
            $ext = $request->file('driver_license_image')->getClientOriginalExtension();
            $driverLicenseImage = $this->upload('delivery-man/', $ext, $request->file('driver_license_image'));
        }

        $curpRfcCertificateImage = null;
        if ($request->has('curp_rfc_certificate_image')) {
            $ext = $request->file('curp_rfc_certificate_image')->getClientOriginalExtension();
            $curpRfcCertificateImage = $this->upload('delivery-man/', $ext, $request->file('curp_rfc_certificate_image'));
        }

        $cofeprisDocumentImage = null;
        if ($request->has('cofepris_document_image')) {
            $ext = $request->file('cofepris_document_image')->getClientOriginalExtension();
            $cofeprisDocumentImage = $this->upload('delivery-man/', $ext, $request->file('cofepris_document_image'));
        }

        return [
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'identity_number' => $request->identity_number,
            'identity_type' => $request->identity_type,
            'vehicle_id' => $request->vehicle_id,
            'zone_id' => $request->zone_id,
            'identity_image' => $identityImage,
            'image' => $imageName,
            'active' => 0,
            'earning' => $request->earning,
            'password' => bcrypt($request->password),
            'driver_license_image' => $driverLicenseImage,
            'curp_rfc' => $request->curp_rfc,
            'curp_rfc_certificate_image' => $curpRfcCertificateImage,
            'cofepris_document_image' => $cofeprisDocumentImage,
        ];
    }

    public function getUpdateData(Object $request, Object $deliveryMan): array
    {
        if ($request->has('image')) {
            $imageName = $this->updateAndUpload('delivery-man/', $deliveryMan->image, 'png', $request->file('image'));
        } else {
            $imageName = $deliveryMan['image'];
        }

        if ($request->has('identity_image')){
            foreach (json_decode($deliveryMan['identity_image'], true) as $img) {
                
                Helpers::check_and_delete('delivery-man/' , $img);
                
            }
            $imgKeeper = [];
            foreach ($request->identity_image as $img) {
                $identityImage = $this->upload('delivery-man/', 'png', $img);
                array_push($imgKeeper, ['img'=>$identityImage, 'storage'=> Helpers::getDisk()]);
            }
            $identityImage = json_encode($imgKeeper);
        } else {
            $identityImage = $deliveryMan['identity_image'];
        }

        $driverLicenseImage = $deliveryMan->driver_license_image;
        if ($request->has('driver_license_image')) {
            $ext = $request->file('driver_license_image')->getClientOriginalExtension();
            $driverLicenseImage = $this->updateAndUpload('delivery-man/', $deliveryMan->driver_license_image ?? '', $ext, $request->file('driver_license_image'));
        }

        $curpRfcCertificateImage = $deliveryMan->curp_rfc_certificate_image;
        if ($request->has('curp_rfc_certificate_image')) {
            $ext = $request->file('curp_rfc_certificate_image')->getClientOriginalExtension();
            $curpRfcCertificateImage = $this->updateAndUpload('delivery-man/', $deliveryMan->curp_rfc_certificate_image ?? '', $ext, $request->file('curp_rfc_certificate_image'));
        }

        $cofeprisDocumentImage = $deliveryMan->cofepris_document_image;
        if ($request->has('cofepris_document_image')) {
            $ext = $request->file('cofepris_document_image')->getClientOriginalExtension();
            $cofeprisDocumentImage = $this->updateAndUpload('delivery-man/', $deliveryMan->cofepris_document_image ?? '', $ext, $request->file('cofepris_document_image'));
        }

        return [
            "f_name" => $request->f_name,
            "l_name" => $request->l_name,
            "email" => $request->email,
            "phone" => $request->phone,
            "identity_number" => $request->identity_number,
            "vehicle_id" => $request->vehicle_id,
            "identity_type" => $request->identity_type,
            "zone_id" => $request->zone_id,
            "identity_image" => $identityImage,
            "image" => $imageName,
            "earning" => $request->earning,
            "driver_license_image" => $driverLicenseImage,
            "curp_rfc" => $request->curp_rfc,
            "curp_rfc_certificate_image" => $curpRfcCertificateImage,
            "cofepris_document_image" => $cofeprisDocumentImage,
            "password" => strlen($request->password)>1?bcrypt($request->password):$deliveryMan['password'],
            "application_status" => in_array($deliveryMan['application_status'], ['pending','denied']) ? 'approved' : $deliveryMan['application_status'],
            "status" => in_array($deliveryMan['application_status'], ['pending','denied']) ? 1 : $deliveryMan['status'],
        ];
    }

}
