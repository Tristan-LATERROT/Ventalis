<?php
// Clef secrete et confidentielle pour signer et authentifier les tokens
const TOKEN_SECRET_KEY = 'M4Cl3fS€cr€7€P0urG3n3r3rL€sT0k3ns!%';
// validitée par défault d'un token : 1 journée
const TOKEN_DEFAULT_VALIDITY = 86400;
// type de token pout JWT
const HEADER_TYPE = 'JWT';
// algo de hash pour JWT
const HEADER_ALGO = 'HS256';