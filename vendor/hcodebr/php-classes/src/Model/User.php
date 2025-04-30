<?php

namespace Hcode\Model; // Define o namespace da classe User, agrupando-a com outras classes do modelo

use \Hcode\Model; // Importa a classe Model para herança
use \Hcode\DB\Sql; // Importa a classe Sql para manipulação do banco de dados

class User extends Model { // Define a classe User, que herda a estrutura da classe base Model

    const SESSION = "User"; // Constante usada como chave de sessão para identificar o usuário logado

    protected $fields = [ // Lista de campos permitidos para leitura e escrita via métodos mágicos da Model
        "iduser", "idperson", "deslogin", "despassword", "inadmin", "dtergister"
    ];

    public static function login($login, $password):User // Método estático para realizar o login; retorna um objeto User
    {

        $db = new Sql(); // Cria uma nova instância da classe Sql (provavelmente um wrapper para PDO)

        // Executa uma consulta SQL buscando o usuário com o login informado
        $results = $db->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
            ":LOGIN"=>$login
        ));

        // Se não encontrar nenhum resultado, lança uma exceção
        if (count($results) === 0) {
            throw new \Exception("Não foi possível fazer login.");
        }

        $data = $results[0]; // Pega o primeiro resultado (usuário encontrado)

        // Verifica se a senha fornecida corresponde à senha criptografada no banco
        if (password_verify($password, $data["despassword"])) {

            $user = new User(); // Cria um novo objeto User
            $user->setData($data); // Preenche o objeto com os dados do banco usando os setters mágicos

            // Salva os dados do usuário na sessão
            $_SESSION[User::SESSION] = $user->getValues();

            return $user; // Retorna o objeto User preenchido

        } else {

            // Se a senha estiver incorreta, lança uma exceção
            throw new \Exception("Não foi possível fazer login.");

        }

    }

    public static function logout() // Método estático que faz logout limpando a sessão do usuário
    {

        $_SESSION[User::SESSION] = NULL;

    }

    public static function verifyLogin($inadmin = true) // Verifica se o usuário está logado e, opcionalmente, se é admin
    {

        if (
            !isset($_SESSION[User::SESSION]) // Se a sessão não existir
            ||
            !$_SESSION[User::SESSION] // Ou se estiver vazia
            ||
            !(int)$_SESSION[User::SESSION]["iduser"] > 0 // Ou se o iduser não for válido
            ||
            (bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin // Ou se não for admin quando deveria ser
        ) {

            // Redireciona para a tela de login caso qualquer verificação falhe
            header("Location: /admin/login");
            exit;

        }

    }

}

?>
