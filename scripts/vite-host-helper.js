/**
 * Vite Host Helper
 * 
 * Este script detecta automáticamente la IP correcta del servidor
 * para que Vite funcione tanto en localhost como via Tailscale u otras redes.
 * 
 * Uso: node scripts/vite-host-helper.js [--get-ip | --update-hot]
 */

import { networkInterfaces } from 'os';
import { writeFileSync, readFileSync, existsSync } from 'fs';
import { join, dirname } from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);
const projectRoot = join(__dirname, '..');

/**
 * Obtiene todas las IPs disponibles del sistema
 */
function getAllIPs() {
    const nets = networkInterfaces();
    const ips = {
        localhost: '127.0.0.1',
        all: []
    };
    
    for (const name of Object.keys(nets)) {
        for (const net of nets[name]) {
            // Ignorar IPs no IPv4 e internas
            if (net.family === 'IPv4') {
                const ipInfo = {
                    ip: net.address,
                    interface: name,
                    internal: net.internal
                };
                
                ips.all.push(ipInfo);
                
                // Detectar IP de Tailscale (típicamente empieza con 100.)
                if (name.toLowerCase().includes('tailscale') || net.address.startsWith('100.')) {
                    ips.tailscale = net.address;
                }
                
                // IP de red local (típicamente empieza con 192.168. o 10.)
                if (!net.internal && (net.address.startsWith('192.168.') || net.address.startsWith('10.'))) {
                    ips.lan = net.address;
                }
            }
        }
    }
    
    return ips;
}

/**
 * Determina la mejor IP para usar basándose en el entorno
 */
function getBestIP(preferTailscale = true) {
    const ips = getAllIPs();
    
    if (preferTailscale && ips.tailscale) {
        return ips.tailscale;
    }
    
    if (ips.lan) {
        return ips.lan;
    }
    
    return ips.localhost;
}

/**
 * Actualiza el archivo hot con la IP correcta
 */
function updateHotFile(ip, port = 5174) {
    const hotPath = join(projectRoot, 'public', 'hot');
    const hotContent = `http://${ip}:${port}`;
    
    writeFileSync(hotPath, hotContent);
    console.log(`✅ Archivo hot actualizado: ${hotContent}`);
    return hotContent;
}

/**
 * Lee la configuración actual del archivo hot
 */
function getCurrentHotConfig() {
    const hotPath = join(projectRoot, 'public', 'hot');
    
    if (existsSync(hotPath)) {
        return readFileSync(hotPath, 'utf-8').trim();
    }
    
    return null;
}

/**
 * Muestra información de todas las IPs disponibles
 */
function showIPInfo() {
    const ips = getAllIPs();
    
    console.log('\n📡 Interfaces de red disponibles:');
    console.log('================================');
    
    for (const ipInfo of ips.all) {
        const marker = ipInfo.internal ? '(interno)' : '(externo)';
        const tailscale = ipInfo.ip.startsWith('100.') ? ' [Tailscale]' : '';
        console.log(`  ${ipInfo.interface}: ${ipInfo.ip} ${marker}${tailscale}`);
    }
    
    console.log('\n🎯 IPs detectadas:');
    console.log(`  Localhost:  ${ips.localhost}`);
    console.log(`  LAN:        ${ips.lan || 'No detectada'}`);
    console.log(`  Tailscale:  ${ips.tailscale || 'No detectada'}`);
    console.log(`\n  Mejor opción: ${getBestIP()}`);
    
    const currentHot = getCurrentHotConfig();
    if (currentHot) {
        console.log(`\n📁 Configuración actual (hot): ${currentHot}`);
    }
}

// CLI
const args = process.argv.slice(2);

if (args.includes('--get-ip')) {
    console.log(getBestIP());
} else if (args.includes('--update-hot')) {
    const ip = args.includes('--localhost') ? '127.0.0.1' : getBestIP();
    updateHotFile(ip);
} else if (args.includes('--update-hot-localhost')) {
    updateHotFile('127.0.0.1');
} else if (args.includes('--info')) {
    showIPInfo();
} else {
    showIPInfo();
    console.log('\n📖 Comandos disponibles:');
    console.log('  --info            Mostrar información de IPs');
    console.log('  --get-ip          Obtener la mejor IP');
    console.log('  --update-hot      Actualizar archivo hot con la mejor IP');
    console.log('  --localhost       Usar localhost en lugar de IP externa');
}

export { getAllIPs, getBestIP, updateHotFile, getCurrentHotConfig };
