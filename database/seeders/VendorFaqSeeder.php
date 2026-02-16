<?php

namespace Database\Seeders;

use App\Models\FAQ;
use App\Models\Translation;
use Illuminate\Database\Seeder;

class VendorFaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $existingCount = FAQ::where('user_type', 'vendor')->count();
        if ($existingCount >= 15) {
            return;
        }

        $faqs = $this->getVendorFaqs();

        foreach ($faqs as $item) {
            $faq = FAQ::create([
                'question' => $item['question_en'],
                'answer' => $item['answer_en'],
                'user_type' => 'vendor',
                'page_type' => 'react_landing_page',
                'status' => 1,
            ]);

            $translationableType = FAQ::class;

            Translation::updateOrCreate(
                [
                    'translationable_type' => $translationableType,
                    'translationable_id' => $faq->id,
                    'locale' => 'en',
                    'key' => 'question',
                ],
                ['value' => $item['question_en']]
            );
            Translation::updateOrCreate(
                [
                    'translationable_type' => $translationableType,
                    'translationable_id' => $faq->id,
                    'locale' => 'en',
                    'key' => 'answer',
                ],
                ['value' => $item['answer_en']]
            );
            Translation::updateOrCreate(
                [
                    'translationable_type' => $translationableType,
                    'translationable_id' => $faq->id,
                    'locale' => 'es-MX',
                    'key' => 'question',
                ],
                ['value' => $item['question_es']]
            );
            Translation::updateOrCreate(
                [
                    'translationable_type' => $translationableType,
                    'translationable_id' => $faq->id,
                    'locale' => 'es-MX',
                    'key' => 'answer',
                ],
                ['value' => $item['answer_es']]
            );
        }
    }

    /**
     * @return array<int, array{question_es: string, answer_es: string, question_en: string, answer_en: string}>
     */
    private function getVendorFaqs(): array
    {
        return [
            [
                'question_es' => '¿Cómo me registro como repartidor?',
                'answer_es' => 'Crea una cuenta en la app, sube tu identificación, licencia, permiso de cofepris, datos bancarios y una foto. El equipo valida y te notifica por la app.',
                'question_en' => 'How do I register as a delivery driver?',
                'answer_en' => 'Create an account in the app, upload your identification, license, Cofepris permit, bank details and a photo. The team validates and notifies you through the app.',
            ],
            [
                'question_es' => '¿Qué requisitos necesito?',
                'answer_es' => "Ser mayor de edad\nIdentificación oficial vigente\nPermiso de Cofepris\nTeléfono con datos y GPS\nMedio de transporte (automovil, gasolina ó electrico. (No motos, no bicicletas, no monopatines).\nLlicencia y seguro del vehiculo.",
                'question_en' => 'What requirements do I need?',
                'answer_en' => "Be of legal age\nValid official identification\nCofepris permit\nPhone with data and GPS\nMeans of transportation (automobile, gasoline or electric. (No motorcycles, no bicycles, no scooters).\nLicense and vehicle insurance.",
            ],
            [
                'question_es' => '¿Cómo recibo pedidos?',
                'answer_es' => 'Cuando estés en línea, te llegarán solicitudes cercanas. Verás tienda, distancia y pago estimado. Acepta para iniciar.',
                'question_en' => 'How do I receive orders?',
                'answer_en' => 'When you are online, nearby requests will arrive. You will see store, distance and estimated payment. Accept to start.',
            ],
            [
                'question_es' => '¿Cómo navego hasta el destino?',
                'answer_es' => 'Desde el pedido, toca "Iniciar ruta" para abrir el mapa integrado con indicaciones giro a giro.',
                'question_en' => 'How do I navigate to the destination?',
                'answer_en' => 'From the order, tap "Start route" to open the integrated map with turn-by-turn directions.',
            ],
            [
                'question_es' => '¿Cómo es el proceso paso a paso?',
                'answer_es' => "Acepta el pedido\nVe a la tienda y marca \"Llegué\"\nRevisa/recoge el paquete\nInicia la ruta al cliente\nMarca \"Entregado\" y solicita confirmación (código/firmado/foto según zona)",
                'question_en' => 'What is the step-by-step process?',
                'answer_en' => "Accept the order\nGo to the store and mark \"Arrived\"\nCheck/pick up the package\nStart the route to the customer\nMark \"Delivered\" and request confirmation (code/signed/photo depending on the area)",
            ],
            [
                'question_es' => '¿Cómo se calcula mi ganancia?',
                'answer_es' => 'Pago base + distancia/tiempo + promociones + propinas (100% para ti). Los montos se muestran antes de aceptar.',
                'question_en' => 'How is my earnings calculated?',
                'answer_en' => 'Base pay + distance/time + promotions + tips (100% for you). The amounts are shown before accepting.',
            ],
            [
                'question_es' => '¿Cuándo me pagan?',
                'answer_es' => 'Liquidez semanal ó quincenal a tu cuenta bancaria. Consulta tu balance y movimientos en "Ganancias".',
                'question_en' => 'When do I get paid?',
                'answer_en' => 'Weekly or biweekly liquidity to your bank account. Check your balance and movements in "Earnings".',
            ],
            [
                'question_es' => '¿Puedo recibir propinas?',
                'answer_es' => 'Sí. El cliente puede dejar propina en la app o en efectivo. En la app, se suma a tu liquidación.',
                'question_en' => 'Can I receive tips?',
                'answer_en' => 'Yes. The customer can leave a tip in the app or in cash. In the app, it is added to your settlement.',
            ],
            [
                'question_es' => '¿Qué hago si la dirección es incorrecta o el cliente no responde?',
                'answer_es' => 'Usa el chat/llamada desde el pedido. Si no hay respuesta en el tiempo establecido, reporta "Cliente no localizable" para recibir instrucciones.',
                'question_en' => 'What do I do if the address is incorrect or the customer does not respond?',
                'answer_en' => 'Use the chat/call from the order. If there is no response in the established time, report "Customer not locatable" to receive instructions.',
            ],
            [
                'question_es' => '¿Qué pasa si la tienda se tarda o no tiene el producto?',
                'answer_es' => 'Regístralo como "Retraso en tienda" ó "Producto no disponible" . Soporte y la tienda indicarán si hay sustitución, ajuste o cancelación.',
                'question_en' => 'What happens if the store is delayed or does not have the product?',
                'answer_en' => 'Register it as "Store delay" or "Product not available". Support and the store will indicate if there is substitution, adjustment or cancellation.',
            ],
            [
                'question_es' => '¿Qué hago si hay un problema con el paquete (daños, sello roto)?',
                'answer_es' => 'No lo entregues. Reporta "Incidencia de paquete" con foto y sigue las indicaciones de soporte.',
                'question_en' => 'What do I do if there is a problem with the package (damages, broken seal)?',
                'answer_en' => 'Do not deliver it. Report "Package incident" with photo and follow support instructions.',
            ],
            [
                'question_es' => '¿Qué políticas de cancelación aplican al repartidor?',
                'answer_es' => "Cancelaciones antes de recoger: sin penalización en la mayoría de los casos.\nCancelar después de recoger: solo por causa justificada (muestra evidencia).\nRevisa tus métricas para evitar penalizaciones.",
                'question_en' => 'What cancellation policies apply to the delivery driver?',
                'answer_en' => "Cancellations before picking up: no penalty in most cases.\nCancel after picking up: only for justified cause (show evidence).\nCheck your metrics to avoid penalties.",
            ],
            [
                'question_es' => '¿Cómo cuido mi tasa de aceptación y puntualidad?',
                'answer_es' => 'Mantén buena conexión, revisa notificaciones y acepta pedidos cercanos. Activa "Zonas preferidas" para recibir solicitudes convenientes.',
                'question_en' => 'How do I take care of my acceptance rate and punctuality?',
                'answer_en' => 'Maintain good connection, check notifications and accept nearby orders. Activate "Preferred zones" to receive convenient requests.',
            ],
            [
                'question_es' => '¿Puedo elegir mis horarios?',
                'answer_es' => 'Sí. Tú decides cuándo conectarte. También puedes reservar bloques en horas de alta demanda para asegurar pedidos.',
                'question_en' => 'Can I choose my schedules?',
                'answer_en' => 'Yes. You decide when to connect. You can also reserve blocks in high-demand hours to secure orders.',
            ],
            [
                'question_es' => '¿Cómo funcionan las zonas y radio de trabajo?',
                'answer_es' => 'En el perfil puedes elegir zonas y un radio máximo. La app te sugiere moverte a "puntos de venta" para más pedidos.',
                'question_en' => 'How do the zones and work radius work?',
                'answer_en' => 'In the profile you can choose zones and a maximum radius. The app suggests moving to "sales points" for more orders.',
            ],
        ];
    }
}
