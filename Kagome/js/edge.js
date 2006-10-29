/**
 *	This class represents an edge in the Kagome backend model.
 *
 *
 *	It is pretty awesome than one can include JS files in LZX applications.
 *	
 *	Every edge has an associated 'event' (we should probably name events 
 *	somethign else but close because 'event' is a reserved keyword in LZX)
 *	object that defines what needs to happen for the edge to be taken. 
 */
 
 /**
  * Constructs an edge
  * Edge types are an enum. For now, possible values are:
  * 0 -> a button press edge
  * 1 -> a times edge ?
  * 2 -> a logical edge
  *
  * 
  */
function Edge(source, target, type, event) {
	this.source = source;
	this.target = target;
	this.type = type;
	this.event = event;
}