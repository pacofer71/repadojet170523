@component('mail::message')
# FORMULARIO DE CONTACTO
## ENVIADO POR:
{{$nombre}}
## EMAIL DEL REMITENTE
{{$email}}
## CONTENIDO DEL MENSAJE
> {{$contenido}}
@endcomponent