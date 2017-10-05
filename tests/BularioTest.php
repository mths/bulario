<?php
/**
 * Bulário: https://github.com/hevertonfreitas/bulario
 * Copyright (c) Heverton Coneglian de Freitas <hevertonconeglian@gmail.com>.
 *
 * Distribuído sob a licença MIT
 * Para informações completas de copyright e distribuição, veja LICENSE.txt
 * Redistribuições de arquivos devem conter a nota de copyright acima.
 *
 * @copyright     Heverton Coneglian de Freitas <hevertonconeglian@gmail.com>
 *
 * @link          https://github.com/hevertonfreitas/bulario
 *
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Hevertonfreitas\Bulario;

use PHPUnit\Framework\TestCase;

class BularioTest extends TestCase
{
    public function testBuscaVazia()
    {
        try {
            $medicamentos = Bulario::buscarMedicamentos('astofo');

            $this->assertEmpty($medicamentos);
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \GuzzleHttp\Exception\ConnectException);
        }
    }

    public function testBulaPacienteValida()
    {
        try {
            $medicamentos = Bulario::buscarMedicamentos('', '', '1862861/17-3');

            foreach ($medicamentos as $medicamento) {
                $headers = get_headers($medicamento->getBulaPaciente()->getUrl(), 1);
                $this->assertContains('pdf', $headers['Content-Type']);
            }
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \GuzzleHttp\Exception\ConnectException);
        }
    }

    public function testBuscaMedicamentos()
    {
        try {
            $medicamentos = [
                'Cloridrato de Propafenona',
                'Dobeven',
                'Dipirona',
                'Aldactone',
                'Albendazol',
            ];
            foreach ($medicamentos as $nome) {
                $medicamentos = Bulario::buscarMedicamentos($nome);
                $this->assertNotEmpty($medicamentos);
            }
        } catch (\Exception $ex) {
            $this->assertTrue($ex instanceof \GuzzleHttp\Exception\ConnectException);
        }
    }
}
