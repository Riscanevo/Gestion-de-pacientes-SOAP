// Endpoints REST que se conectan al servicio SOAP
const express = require('express');
const soap = require('soap');
const url = require('url');
const fs = require('fs');
const path = require('path');

// En el servidor (server.js), después de crear la app de Express:
const wsdlUrl = 'http://localhost:3000/soap?wsdl';

// Endpoints REST para el frontend
module.exports = function setupAPI(app) {

  // RF-01: Registrar Paciente
  app.post('/api/registrar', async (req, res) => {
    console.log("📌 Endpoint /api/registrar llamado");
    try {
      const client = await soap.createClientAsync(wsdlUrl);
      const result = await client.registrarPacienteAsync({ paciente: req.body });
      res.json(result[0].respuesta);
    } catch (error) {
      res.json({ exitoso: false, mensaje: error.message });
    }
  });

  // RF-02: Buscar Paciente
  app.get('/api/buscar/:cedula', async (req, res) => {
    console.log("📌 Endpoint /api/buscar llamado");
    try {
      const client = await soap.createClientAsync(wsdlUrl);
      const result = await client.buscarPacienteAsync({ cedula: req.params.cedula });
      res.json(result[0].respuesta);
    } catch (error) {
      res.json({ exitoso: false, mensaje: error.message });
    }
  });

  // RF-03: Listar Pacientes
  app.get('/api/listar', async (req, res) => {
    console.log("📌 Endpoint /api/listar llamado");
    try {
      const client = await soap.createClientAsync(wsdlUrl);
      const result = await client.listarPacientesAsync({});
      res.json(result[0].respuesta);
    } catch (error) {
      res.json({ exitoso: false, mensaje: error.message });
    }
  });

  // RF-04: Actualizar Paciente
  app.post('/api/actualizar', async (req, res) => {
    console.log("📌 Endpoint /api/actualizar llamado");
    try {
      const { cedula, ...pacienteData } = req.body;
      const client = await soap.createClientAsync(wsdlUrl);
      const result = await client.actualizarPacienteAsync({ 
        cedula, 
        paciente: pacienteData 
      });
      res.json(result[0].respuesta);
    } catch (error) {
      res.json({ exitoso: false, mensaje: error.message });
    }
  });

  // RF-05: Eliminar Paciente
  app.post('/api/eliminar', async (req, res) => {
    console.log("📌 Endpoint /api/eliminar llamado");
    try {
      const client = await soap.createClientAsync(wsdlUrl);
      const result = await client.eliminarPacienteAsync({ cedula: req.body.cedula });
      res.json(result[0].respuesta);
    } catch (error) {
      res.json({ exitoso: false, mensaje: error.message });
    }
  });
};


  // RF-05: Eliminar Paciente
  app.post('/api/eliminar', async (req, res) => {
    try {
      const client = await soap.createClientAsync(wsdlUrl);
      const result = await client.eliminarPacienteAsync({ cedula: req.body.cedula });
      res.json(result[0].respuesta);
    } catch (error) {
      res.json({ exitoso: false, mensaje: error.message });
    }
  });

