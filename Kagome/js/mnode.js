/**
 *	This class defines a node in the Kagome backend mode. The LZX class "knode"
 *	is the graphical represenation of a node in Kagome. In other words, this is part
 *	of the model, while knode is part of a view. Each node in thew view (knode) will
 *	a corresponding node in the model (mnode).
 *
 *	This will contain the properties than can be edited in the node properties dialog. 
 *
 *	The nodes model is driven by the defined template.
 *	We need to research how inheritance works in JS. This would then be the base
 *	class for all model nodes, and every device template would then extend this
 *	and define their own node.
 */
 
 function MNode(id) {
 	this.id = id;
 }