/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package scan;
import java.io.*;
import java.util.*;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
/**
 *
 * @author cpyree
 */
public class Scan {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        FindMp3Files("D:\\DBS");
    }
    
    public static void FindMp3Files(String dir) {
        File actual = new File(dir);
        String ext;
        
        for( File f : actual.listFiles()){
            //System.out.println( f.getName() );
            
            if(f.isDirectory()){
                FindMp3Files(f.getAbsolutePath());
            }
            else if(f.isFile() &&  f.getName().endsWith(".mp3")){
                System.out.println(f.getAbsolutePath()+ ";" +getMd5(f.getAbsolutePath()));   

            }
            /*if(curFileIsDir){
                FindMp3Files(f.getAbsolutePath());
            }*/
        }        
    }
    
    public static String getMd5(String str){
        byte[] uniqueKey = str.getBytes();
        byte[] hash      = null;
        
        try
        {
            hash = MessageDigest.getInstance("MD5").digest(uniqueKey);
        }
        catch (NoSuchAlgorithmException e)
        {
            throw new Error("No MD5 support in this VM.");
        }

        StringBuilder hashString = new StringBuilder();
        for (int i = 0; i < hash.length; i++)
        {
                String hex = Integer.toHexString(hash[i]);
                if (hex.length() == 1)
                {
                        hashString.append('0');
                        hashString.append(hex.charAt(hex.length() - 1));
                }
                else
                        hashString.append(hex.substring(hex.length() - 2));
        } 
        return hashString.toString();
    }
    
    
}
