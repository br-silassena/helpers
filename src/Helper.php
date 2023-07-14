<?php

declare(strict_types=1);

namespace BrSilassena\Helpers;

use Exception;

abstract class Helper
{
    /**
     * Recebe um mês em numero e devolve o nome
     *
     * @var int $mes
     * @return string
     */
    final public static function nomeMes(int $mes): string
    {
        switch ($mes) {

            case 1:
                return 'Janeiro';
            case 2:
                return 'Fevereiro';
            case 3:
                return 'Março';
            case 4:
                return 'Abril';
            case 5:
                return 'Maio';
            case 6:
                return 'Junho';
            case 7:
                return 'Julho';
            case 8:
                return 'Agosto';
            case 9:
                return 'Setembro';
            case 10:
                return 'Outubro';
            case 11:
                return 'Novembro';
            case 12:
                return 'Dezembro';
            default:
                return $mes;
        }
    }

    /**
     * Recebe a imagem com o seu caminho relativo ex: imagens/usuario/nome_imagem.jpg
     * aplica compressao e sobrescreve a imagem original
     *
     * @param string $imagemOriginal
     * @param int $compressao
     * @return string
     */
    final public static function comprimirImagem(string $imagemOriginal, int $compressao = 70): bool
    {
        try {

            // Caminho completo para a imagem no servidor
            $caminhoImagem = self::pngToJPEG($imagemOriginal);

            // Carrega a imagem original
            $imagem = imagecreatefromjpeg($caminhoImagem);

            // Obtém as informações da imagem original
            $larguraOriginal = imagesx($imagem);
            $alturaOriginal = imagesy($imagem);

            // Cria uma nova imagem com as dimensões desejadas
            $novaImagem = imagecreatetruecolor($larguraOriginal, $alturaOriginal);

            imagecopyresampled($novaImagem, $imagem, 0, 0, 0, 0, $larguraOriginal, $alturaOriginal, $larguraOriginal, $alturaOriginal);

            // Salva a nova imagem comprimida
            imagejpeg($novaImagem, $caminhoImagem, $compressao);

            // Libera a memória utilizada
            imagedestroy($imagem);
            imagedestroy($novaImagem);

            // Retorne a resposta com a imagem comprimida
            return true;
        } catch (Exception $e) {

            echo $e->getMessage();

            return false;
        }
    }

    /**
     * Recebe o caminho de um arquivo de imagem, verifica se é PNG e converte para JPG!
     *
     * @param string $imagemPNG
     * @return string
     */
    final public static function pngToJPEG($imagemPNG): string
    {
        try {

            //se a imagem nao for png, devolve a imagem que recebeu sem converter
            if (!(strpos($imagemPNG, '.png') || strpos($imagemPNG, '.PNG'))) {

                return $imagemPNG;
            }

            //$imagemPNG = "caminho/para/imagem.png"; // Caminho da imagem PNG
            $imagemJPEG = str_replace([".png", ".PNG"], ".jpg", $imagemPNG); // Caminho para salvar a imagem convertida em formato JPEG

            // Carrega a imagem PNG
            $imagem = imagecreatefrompng($imagemPNG);

            // Cria uma nova imagem em branco com as mesmas dimensões
            $imagemJpeg = imagecreatetruecolor(imagesx($imagem), imagesy($imagem));

            // Define o fundo branco para a imagem JPEG
            $corBranca = imagecolorallocate($imagemJpeg, 255, 255, 255);
            imagefill($imagemJpeg, 0, 0, $corBranca);

            // Copia a imagem PNG para a imagem JPEG com transparência convertida em branco
            imagecopy($imagemJpeg, $imagem, 0, 0, 0, 0, imagesx($imagem), imagesy($imagem));

            // Salva a imagem convertida em formato JPEG
            imagejpeg($imagemJpeg, $imagemJPEG, 100); // 100 é a qualidade da imagem JPEG (0 a 100)

            // Libera a memória usada pelas imagens
            imagedestroy($imagem);
            imagedestroy($imagemJpeg);

            //remove a imagem png do servidor
            unlink($imagemPNG);

            return $imagemJPEG;
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Redimensiona uma imagem para as dimensoes fornecidas
     * 
     * @param string $caminhoImagem
     * @param int $larguraNova
     * @param int $alturaNova
     * @return bool
     */
    final public static function redimensionarImagens(string $caminhoImagem, int $larguraNova, int $alturaNova): bool
    {
        try {

            // Carrega a imagem original
            $imagem = imagecreatefromjpeg($caminhoImagem);

            // Obtém as informações da imagem original
            $larguraOriginal = imagesx($imagem);
            $alturaOriginal = imagesy($imagem);

            // Cria uma nova imagem com as dimensões desejadas
            $novaImagem = imagecreatetruecolor($larguraNova, $alturaNova);

            // Redimensiona a imagem original para a nova imagem
            imagecopyresampled($novaImagem, $imagem, 0, 0, 0, 0, $larguraNova, $alturaNova, $larguraOriginal, $alturaOriginal);

            // Salva a imagem convertida em formato JPEG
            imagejpeg($novaImagem, $caminhoImagem, 100); // 100 é a qualidade da imagem JPEG (0 a 100)

            // Libera a memória usada pelas imagens
            imagedestroy($imagem);

            return true;
        } catch (Exception $e) {

            return false;
        }
    }
}
