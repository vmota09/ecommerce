<?php

namespace Hcode; // Define o namespace da classe, agrupando-a com as demais do projeto

class Model { // Define a classe base Model, usada para facilitar o mapeamento de dados

    private $values = []; // Armazena os dados do modelo (campos e seus valores)

    public function setData($data) // Método que recebe um array de dados e define os valores usando os setters dinâmicos
    {

        foreach ($data as $key => $value) // Percorre cada par chave => valor do array
        {

            $this->{"set".$key}($value); // Chama dinamicamente o método setNomeDoCampo (ex: setName("João"))

        }

    }

    public function __call($name, $args) // Método mágico chamado quando um método inexistente é chamado na classe
    {

        $method = substr($name, 0, 3); // Extrai os primeiros 3 caracteres do nome do método (get ou set)
        $fieldName = substr($name, 3, strlen($name)); // Extrai o restante do nome (ex: "Name" de "getName")

        if (in_array($fieldName, $this->fields)) // Verifica se o campo acessado existe na lista de campos válidos da classe
        {

            switch ($method) // Verifica se a chamada foi para "get" ou "set"
            {

                case "get": // Se for um getter
                    return $this->values[$fieldName]; // Retorna o valor do campo
                    break;

                case "set": // Se for um setter
                    $this->values[$fieldName] = $args[0]; // Define o valor do campo
                    break;

            }

        }

    }

    public function getValues() // Retorna todos os valores armazenados no modelo
    {

        return $this->values;

    }

}
